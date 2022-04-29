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
    $pasaran = ConstantProviderTogelModel::where('name', $request->provider)->first();
    $game    = TogelGame::select(['id','name'])->where('name', $request->type)->first();
    if(is_null($pasaran)){
      return $this->errorResponse('Nama pasaran tidak ditemukan', 400);
    }
    if(is_null($game)){
      return $this->errorResponse('Jenis game tidak ditemukan', 400);
    }
    // First For All Take The Type Of Game 
    $togelGames = TogelGame::query()->get()->pluck(['id'], 'name');
    $providerGame = ConstantProviderTogelModel::query()->get()->pluck(['id'], 'name');

    // Cek From Request or Body Has Value Type Of Games
    // $this->checkType();
    // take type of game and provider
    $gameType = $togelGames[$request->type];
    $provider = $providerGame[$request->provider];

    // $togel_result_number = TogelResultNumberModel::query()
    //   ->where('constant_provider_togel_id', $provider)
    //   ->latest('result_date')
    //   ->first();
    $periodProvider = ConstantProviderTogelModel::query()
      ->where('id', $provider)
      ->first();

    // get setting games 
    $settingGames = $this->getSettingGames($gameType, $provider)->first();

    $bets = [];
    $total_bets_after_disc = [];

    $bonus = ConstantProviderTogelModel::pluck('value', 'name_initial');

    // dd(json_encode($this->checkBlokednumber($request, $provider)));
    // Loop the validated data and take key data and remapping the key
    try {
      foreach ($this->checkBlokednumber($request, $provider) as $togel) {
        // dd($togels);
        // $togel = json_decode($togels, true);     
        // definition of bonus referal
        $calculateReferal = $bonus["$pasaran->name_initial"] * $togel['pay_amount'];
        // $calculateReferal = $provider === 1 ? $bonus['HKD'] * $togel['pay_amount'] : ($provider === 2 ? $bonus['NZB'] * $togel['pay_amount'] : ($provider === 3 ? $bonus['SY'] * $togel['pay_amount'] : ($provider === 4 ? $bonus['HAI'] * $togel['pay_amount'] : ($provider === 5 ? $bonus['SG'] * $togel['pay_amount'] : ($provider === 6 ? $bonus['JINAN'] * $togel['pay_amount'] : ($provider === 7 ? $bonus['QTR'] * $togel['pay_amount'] : ($provider === 8 ? $bonus['BGP'] * $togel['pay_amount'] : ($provider === 9 ? $bonus['HK'] * $togel['pay_amount'] : ($provider === 10 ? $bonus['SGP45'] * $togel['pay_amount'] : '')))))))));

        array_push($bets, array_merge($togel, [
          // 'period'      => is_null($togel_result_number) ? 1 : intval($togel_result_number->period) + 1,
          'period'      => $periodProvider->period,
          'bonus_daily_referal' => $calculateReferal,
          "togel_game_id" => $gameType,
          "constant_provider_togel_id" => $provider,
          'togel_setting_game_id' => is_null($settingGames) ? null : $settingGames->id, // will be error if the foreign key not release 
          'created_by' => auth('api')->user()->id, // Laravel Can Handler which user has login please cek config.auth folder
          'created_at' => now()
        ]));

        // get member bet
        $member =  MembersModel::where('id', auth('api')->user()->id)->first();
        DB::beginTransaction();
        $member->update([
          'update_at' => Carbon::now(),
          'bonus_referal' => $member->bonus_referal + $calculateReferal,
          // 'bonus_referal' => $provider === 1 ? $member->bonus_referal + ($bonus['HKD'] * $togel['pay_amount']) : ($provider === 2 ? $member->bonus_referal + ($bonus['NZB'] * $togel['pay_amount']) : ($provider === 3 ? $member->bonus_referal + ($bonus['SY'] * $togel['pay_amount']) : ($provider === 4 ? $member->bonus_referal + ($bonus['HAI'] * $togel['pay_amount']) : ($provider === 5 ? $member->bonus_referal + ($bonus['SG'] * $togel['pay_amount']) : ($provider === 6 ? $member->bonus_referal + ($bonus['JINAN'] * $togel['pay_amount']) : ($provider === 7 ? $member->bonus_referal + ($bonus['QTR'] * $togel['pay_amount']) : ($provider === 8 ? $member->bonus_referal + ($bonus['BGP'] * $togel['pay_amount']) : ($provider === 9 ? $member->bonus_referal + ($bonus['HK'] * $togel['pay_amount']) : ($provider === 10 ? $member->bonus_referal + ($bonus['SGP45'] * $togel['pay_amount']) : ''))))))))),
        ]);
        DB::commit();

        // check if any referrer
        if ($member->referrer_id) {
          // calculate bonus have referrer
          $referal =  MembersModel::where('id', $member->referrer_id)->first();
          DB::beginTransaction();
          $referal->update([
            'update_at' => Carbon::now(),
            'credit' => $referal->credit + $calculateReferal,
            // 'credit' => $provider === 1 ? $referal->credit + ($bonus['HKD'] * $togel['pay_amount']) : ($provider === 2 ? $referal->credit + ($bonus['NZB'] * $togel['pay_amount']) : ($provider === 3 ? $referal->credit + ($bonus['SY'] * $togel['pay_amount']) : ($provider === 4 ? $referal->credit + ($bonus['HAI'] * $togel['pay_amount']) : ($provider === 5 ? $referal->credit + ($bonus['SG'] * $togel['pay_amount']) : ($provider === 6 ? $referal->credit + ($bonus['JINAN'] * $togel['pay_amount']) : ($provider === 7 ? $referal->credit + ($bonus['QTR'] * $togel['pay_amount']) : ($provider === 8 ? $referal->credit + ($bonus['BGP'] * $togel['pay_amount']) : ($provider === 9 ? $referal->credit + ($bonus['HK'] * $togel['pay_amount']) : ($provider === 10 ? $referal->credit + ($bonus['SGP45'] * $togel['pay_amount']) : ''))))))))),
          ]);

          // create bonus history
          BonusHistoryModel::create([
            'constant_bonus_id' => 3,
            'created_by' => $member->referrer_id,
            'created_at' => Carbon::now(),
            'jumlah' => $calculateReferal,
          ]);
          DB::commit();
        }

        // Sum pay_amount
        array_push($total_bets_after_disc, floatval($togel['pay_amount']));
      }
      return response()->json(['message' => "Total betingan : ".array_sum($total_bets_after_disc), 'code' => 200], 200);
      dd();
    
      // if (empty($bets)) {        
      //   return response()->json(['message' => 'success', 'code' => 200], 200);
      // }
      // DB::beginTransaction();
      
      $idx = [];

      foreach ($bets as $bet) {
        DB::beginTransaction();
        $idx[] = DB::table('bets_togel')->insertGetId($bet);
        
        DB::commit();
      }

      // dd($idx);
      // TODO need chunks the array of $idx and inserting to DB
      // $chunkIdx = array_chunk($idx, 50);
      // foreach ($idx as $id) {
        DB::beginTransaction();
        $this->inserBetTogelToHistory($idx);
        $response = $this->CheckIsBuangan($idx);
        DB::commit();
      // }
      // Cek This is Bet Buangan 
      if ($response != []) {
        if ($response[0]->results != null) {
          foreach (json_decode($response[0]->results) as $bet) {
            DB::beginTransaction();
            BetsTogel::query()
              ->where('id', $bet->bet_id)
              ->where('constant_provider_togel_id', $bet->constant_provider_togel_id)
              ->update([
                'is_bets_buangan' => $bet->is_bets_buangan,
                'buangan_before_submit' => $bet->buangan_before_submit,
              ]);
            DB::commit();
          }
        }
      }

      
      
      $this->updateCredit($total_bets_after_disc);

      

      // ConstantProviderTogelModel::query()
      //   ->where('id', '=', $provider)
      //   ->update(['period' => is_null($togel_result_number) ? 1 : intval($togel_result_number->period) + 1]);

      // DB::commit();


      return response()->json(['message' => 'success', 'code' => 200], 200);
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
    dd(array_sum($totalBets));
    if (auth('api')->user()->credit === 0) {
      return response()->json([
        'code' => 422,
        'message' => 'saldo kurang'
      ], 422);
    }

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
  protected function CheckIsBuangan(array $betsId)
  {
    $bets_id  = implode(",", $betsId);
    DB::select("SET @bet_ids=' a.id in (" . $bets_id . ")';");
    return DB::select("CALL is_buangan_before_terpasang(@bet_ids)"); // will be return empty
  }
}
