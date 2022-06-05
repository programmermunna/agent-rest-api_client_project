<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BetsTogelRequest;
use App\Models\BetsTogel;
use App\Models\ConstantProviderTogelModel;
use App\Models\TogelGame;
use App\Models\TogelResultNumberModel;
use App\Models\TogelBlokAngka;
use App\Models\TogelSettingGames;
use App\Models\MembersModel;
use App\Models\BonusHistoryModel;
use Carbon\Carbon;
use Exception as NewException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BetsTogelController extends ApiController
{
  /**
   * storingBetsTogel place the bet togels  
   * @param BetsTogelRequest $request
   */
  public function store(BetsTogelRequest $request)
  {    
    $start = microtime(true);

    # check if credit member 0
    if (auth('api')->user()->credit === 0) {
      return response()->json([
        'code' => 422,
        'message' => 'saldo kurang'
      ], 422);
    }

    # check pasaran and game togel
    $pasaran = ConstantProviderTogelModel::where('name', $request->provider)->first();
    $game    = TogelGame::select(['id','name'])->where('name', $request->type)->first();
    if(is_null($pasaran)){
      return $this->errorResponse('Nama pasaran tidak ditemukan', 400);
    }
    if(is_null($game)){
      return $this->errorResponse('Jenis game tidak ditemukan', 400);
    }

    # First For All Take The Type Of Game 
    $togelGames = TogelGame::query()->get()->pluck(['id'], 'name');
    $providerGame = ConstantProviderTogelModel::query()->get()->pluck(['id'], 'name');

    # Cek From Request or Body Has Value Type Of Games
    # take type of game and provider
    $gameType = $togelGames[$request->type];
    $provider = $providerGame[$request->provider];

    $periodProvider = ConstantProviderTogelModel::query()
      ->where('id', $provider)
      ->first();

    # get setting games 
    $settingGames = $this->getSettingGames($gameType, $provider)->first();

    $bonus = ConstantProviderTogelModel::pluck('value', 'name_initial');

    # Loop the validated data and take key data and remapping the key
    
    try {
      
      DB::beginTransaction();
      foreach ($this->checkBlokednumber($request, $provider) as $togel) {    
        # definition of bonus referal
        $calculateReferal = $bonus["$pasaran->name_initial"] * $togel['pay_amount'];
        
        # get member bet
        $member =  MembersModel::where('id', auth('api')->user()->id)->first();
        $payBetTogel = $togel['pay_amount'];
        $beforeBets = array_merge($togel, [
          'balance' => $member->credit - $payBetTogel,
          'period'      => $periodProvider->period,
          'bonus_daily_referal' => $calculateReferal,
          "togel_game_id" => $gameType,
          "constant_provider_togel_id" => $provider,
          'togel_setting_game_id' => is_null($settingGames) ? null : $settingGames->id, // will be error if the foreign key not release 
          'created_by' => auth('api')->user()->id, // Laravel Can Handler which user has login please cek config.auth folder
          'created_at' => now()
        ]);

        # check is buangan
        $afterBet = DB::table('bets_togel')->insertGetId($beforeBets);
        $checkBetBuangan = $this->CheckIsBuangan($afterBet);
        if ($checkBetBuangan != []) {
          if ($checkBetBuangan[0]->results != null) {
            foreach (json_decode($checkBetBuangan[0]->results) as $bet) {
              BetsTogel::query()
                ->where('id', $bet->bet_id)
                ->where('constant_provider_togel_id', $bet->constant_provider_togel_id)
                ->update([
                  'is_bets_buangan' => $bet->is_bets_buangan,
                  'buangan_before_submit' => $bet->buangan_before_submit,
                ]);
            }
          }
        }
        # update member
        $member->update([
          'credit' => $member->credit - $payBetTogel,
          'update_at' => Carbon::now(),
          'bonus_referal' => $member->bonus_referal + $calculateReferal,
        ]);

        # check if any referrer
        if ($member->referrer_id) {
          // calculate bonus have referrer
          $referal =  MembersModel::where('id', $member->referrer_id)->first();
          $referal->update([
            'update_at' => Carbon::now(),
            'credit' => $referal->credit + $calculateReferal,
          ]);

          # create bonus history
          BonusHistoryModel::create([
            'constant_bonus_id' => 3,
            'created_by' => $member->referrer_id,
            'created_at' => Carbon::now(),
            'jumlah' => $calculateReferal,
          ]);
        }
      }      

      $finish = microtime(true);
      $hasil = $finish - $start;
      $milliseconds = round($hasil * 1000);
      $seconds = $milliseconds / 1000;
      return response()->json(['message' => 'success, milliseconds : '. $milliseconds .'ms, seconds : '. $seconds .' s', 'code' => 200], 200);
      
    } catch (Throwable $error) {
      DB::rollBack();
      Log::error($error->getMessage());
      return $error->getMessage();
    }  
  }

  // Check if exist on request 
  // @return void
  protected function checkType(): void
  {
    if (!isset(request()->type) || empty(request()->type)) {
      throw new NewException("type is empty please fill", 400);
    } else if (!isset(request()->provider) || empty(request()->provider)) {
      throw new NewException("Provider Cannot  empty please fill", 400);
    }
  }

  /**
   * Get Setting Games 
   * @param int $gameType
   * @param int $gameProvider
   * @return Builder
   */
  protected function getSettingGames(int $gameType, int $gameProvider): Builder
  {
    $result = TogelSettingGames::query()
      ->where('constant_provider_togel_id', '=', $gameProvider)
      ->where('togel_game_id', '=', $gameType);

    return $result;
  }

  /**
   * this will cek the bloked number 
   * and return safe number after the we be marging the data 
   * @param BetsTogelRequest $request
   * @param array $number
   */
  protected function checkBlokedNumber(BetsTogelRequest $request, int $provider)
  {
    $blokedsNumber = [];

    $stackNumber = ['number_3', 'number_4', 'number_5', 'number_6'];
    if (!in_array($request->validationData()['data'], $stackNumber)) {
      // this iterator will be filtere the bloked number from request and running the triger 
      //  which number will bloked 
      foreach ($request->validationData()['data'] as $key => $data) {
        $c_number_3 = $data['number_3'] ?? 'is null';
        $c_number_4 = $data['number_4'] ?? 'is null';
        $c_number_5 = $data['number_5'] ?? 'is null';
        $c_number_6 = $data['number_6'] ?? 'is null';

        $number_3 =  $c_number_3 == "is null" ? '' : "number_3={$c_number_3} and ";
        $number_4 =  $c_number_4 == "is null" ? '' : "number_4={$c_number_4} and ";
        $number_5 =  $c_number_5 == "is null" ? '' : "number_5={$c_number_5} and ";
        $number_6 =  $c_number_6 == "is null" ? '' : "number_6={$c_number_6} and ";

        $query = $number_3 . $number_4 . $number_5 . $number_6 . "constant_provider_togel_id = " . $provider . " and deleted_at is null";
        $result = DB::select("CALL trigger_togeL_blok_angka_after_bets_togel('" . $query . "')");
        // Cek if result from bloked number is null is approved number
        if ($result[0]->nomor == null) {
          array_push($blokedsNumber, $request->validationData()['data'][$key]);
        }
      }
      return $blokedsNumber;
    }
    return $request->validationData()['data'];
  }

  /**
   * update The Credit
   * @param array $totalBets
   */
  protected function updateCredit($totalBets)
  {
    $credit = floatval(auth('api')->user()->credit) - array_sum($totalBets);
    auth('api')->user()->update([
      'credit' => $credit
    ]);
  }
  /**
   * @param array $betsId array of bets id  
   */
  protected function inserBetTogelToHistory(array $betsId)
  {
    /// will be convert to 1,2,3,4,5    
    $bets_id  = implode(",", $betsId);
    DB::select("CALL TriggerInsertAfterBetsTogel('" . $bets_id . "')"); // will be return empty
  }

  /**
   * @param array $betsId array of bets id  
   */
  protected function CheckIsBuangan($betsId)
  {
    $bets_id  = $betsId;
    DB::select("SET @bet_ids=' a.id in (" . $bets_id . ")';");
    return DB::select("CALL is_buangan_before_terpasang(@bet_ids)"); // will be return empty
  }
  // protected function CheckIsBuangan(array $betsId)
  // {
  //   $bets_id  = implode(",", $betsId);
  //   DB::select("SET @bet_ids=' a.id in (" . $bets_id . ")';");
  //   return DB::select("CALL is_buangan_before_terpasang(@bet_ids)"); // will be return empty
  // }
}
