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
    // $start = microtime(true);

    # check if credit member 0
    if (auth('api')->user()->credit === 0) {
      return response()->json([
        'code' => 422,
        'message' => 'saldo kurang'
      ], 422);
    }

    # check sisa quota
    $sisaQuota = $this->sisaQuota($request);
    if ($sisaQuota == true) {
      return $this->errorResponse($sisaQuota, 400);
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

      DB::commit();

      // $finish = microtime(true);
      // $hasil = $finish - $start;
      // $milliseconds = round($hasil * 1000);
      // $seconds = $milliseconds / 1000;
      // return response()->json(['message' => 'success, milliseconds : '. $milliseconds .'ms, seconds : '. $seconds .' s', 'code' => 200], 200);
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

  # check sisa Quota
  protected function sisaQuota(BetsTogelRequest $request){
    try {

      $pasaran = ConstantProviderTogelModel::where('name', $request->provider)->first();
      $game    = TogelGame::select(['id','name'])->where('name', $request->type)->first();
      if(is_null($pasaran)){
        return $this->errorResponse('Nama pasaran tidak ditemukan', 400);
      }
      if(is_null($game)){
        return $this->errorResponse('Jenis game tidak ditemukan', 400);
      }
      $lastPeriod = BetsTogel::select('period')->latest()->first();
      $results = [];
      foreach ($request->data as $key => $data) {
        $number_3 = array_key_exists('number_3', $data) ? $data['number_3'] : null;
        $number_4 = array_key_exists('number_4', $data) ? $data['number_4'] : null;
        $number_5 = array_key_exists('number_5', $data) ? $data['number_5'] : null;
        $number_6 = array_key_exists('number_6', $data) ? $data['number_6'] : null;
        $tebak_as_kop_kepala_ekor = array_key_exists('tebak_as_kop_kepala_ekor', $data) ? $data['tebak_as_kop_kepala_ekor'] : null;
        $tebak_besar_kecil = array_key_exists('tebak_besar_kecil', $data) ? $data['tebak_besar_kecil'] : null;
        $tebak_genap_ganjil = array_key_exists('tebak_genap_ganjil', $data) ? $data['tebak_genap_ganjil'] : null;
        $tebak_tengah_tepi = array_key_exists('tebak_tengah_tepi', $data) ? $data['tebak_tengah_tepi'] : null;
        $tebak_depan_tengah_belakang = array_key_exists('tebak_depan_tengah_belakang', $data) ? $data['tebak_depan_tengah_belakang'] : null;
        $tebak_mono_stereo = array_key_exists('tebak_mono_stereo', $data) ? $data['tebak_mono_stereo'] : null;
        $tebak_kembang_kempis_kembar = array_key_exists('tebak_kembang_kempis_kembar', $data) ? $data['tebak_kembang_kempis_kembar'] : null;
        $tebak_shio = array_key_exists('tebak_shio', $data) ? $data['tebak_shio'] : null;

        $checkBetTogels = BetsTogel::join('members', 'bets_togel.created_by', '=', 'members.id')  
            ->join('constant_provider_togel', 'bets_togel.constant_provider_togel_id', '=', 'constant_provider_togel.id')  
            ->join('togel_game', 'bets_togel.togel_game_id', '=', 'togel_game.id')
            ->leftJoin('togel_shio_name', 'bets_togel.tebak_shio', '=', 'togel_shio_name.id')
            ->join('togel_setting_game', 'bets_togel.togel_setting_game_id', '=', 'togel_setting_game.id')
            ->selectRaw("
                SUM(bets_togel.bet_amount) as totalBet,
                togel_game.name,
                if (
                  bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                  , concat(bets_togel.number_3, bets_togel.number_4, bets_togel.number_5, bets_togel.number_6)
                  , if (
                      bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                      , concat(bets_togel.number_4, bets_togel.number_5, bets_togel.number_6)
                      , if (
                          bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                          , concat(bets_togel.number_5, bets_togel.number_6)
                          , if (
                              bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                              , concat(bets_togel.number_4, bets_togel.number_5)
                              , if (
                                  bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                  , concat(bets_togel.number_3, bets_togel.number_4)
                                  , if (
                                      togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_5 is null
                                      ,bets_togel.number_6
                                      , if (
                                          togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_6 is null
                                          ,bets_togel.number_5
                                          , if (
                                              togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                              ,bets_togel.number_4
                                              , if (
                                                  togel_game.id = 5 and bets_togel.number_4 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                  ,bets_togel.number_3
                                                  , if (
                                                      togel_game.id = 6
                                                      , concat(bets_togel.number_5, bets_togel.number_6)
                                                      , if (
                                                          togel_game.id = 7
                                                          , concat(bets_togel.number_4, bets_togel.number_5, bets_togel.number_6)
                                                          , if (
                                                              togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_5 is null
                                                              , concat(bets_togel.number_6, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                              , if (
                                                                  togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_6 is null
                                                                  , concat(bets_togel.number_5, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                  , if (
                                                                      togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                                      , concat(bets_togel.number_4, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                      , if (
                                                                          togel_game.id = 8 and bets_togel.number_4 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                                          , concat(bets_togel.number_3, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                          , if (
                                                                              togel_game.id = 9
                                                                              , if (
                                                                                  bets_togel.tebak_besar_kecil is null
                                                                                  , if (
                                                                                      bets_togel.tebak_genap_ganjil is null
                                                                                      , if (
                                                                                          bets_togel.tebak_tengah_tepi is null
                                                                                          , 'nulled'
                                                                                          , bets_togel.tebak_tengah_tepi
                                                                                      )
                                                                                      , bets_togel.tebak_genap_ganjil
                                                                                  )
                                                                                  , bets_togel.tebak_besar_kecil
                                                                              )
                                                                              , if (
                                                                                  togel_game.id = 10
                                                                                  , if (
                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                      , concat('as', '-', 'genap')
                                                                                      , if (
                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                          , concat('as', '-', 'ganjil')
                                                                                          , if (
                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                              , concat('kop', '-', 'genap')
                                                                                              , if (
                                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                  , concat('kop', '-', 'ganjil')
                                                                                                  , if (
                                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                      , concat('kepala', '-', 'genap')
                                                                                                      , if (
                                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                          , concat('kepala', '-', 'ganjil')
                                                                                                          , if (
                                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                              , concat('ekor', '-', 'genap')
                                                                                                              , if (
                                                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                  , concat('ekor', '-', 'ganjil')
                                                                                                                  , if (
                                                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                      , concat('as', '-', 'besar')
                                                                                                                      , if (
                                                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                          , concat('as', '-', 'kecil')
                                                                                                                          , if (
                                                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                              , concat('kop', '-', 'besar')
                                                                                                                              , if (
                                                                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                  , concat('kop', '-', 'kecil')
                                                                                                                                  , if (
                                                                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                                      , concat('kepala', '-', 'besar')
                                                                                                                                      , if (
                                                                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                          , concat('kepala', '-', 'kecil')
                                                                                                                                          , if (
                                                                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                                              , concat('ekor', '-', 'besar')
                                                                                                                                              , if (
                                                                                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                                  , concat('ekor', '-', 'kecil')
                                                                                                                                                  , 'nulled'
                                                                                                                                              )
                                                                                                                                          )
                                                                                                                                      )
                                                                                                                                  )
                                                                                                                              )
                                                                                                                          )
                                                                                                                      )
                                                                                                                  )
                                                                                                              )
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                              )
                                                                                          )
                                                                                      )
                                                                                  )
                                                                                  , if (
                                                                                      togel_game.id = 11
                                                                                      , if (
                                                                                          bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                          , concat('belakang', ' - ', 'stereo')
                                                                                          , if (
                                                                                              bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                              , concat('belakang', ' - ', 'mono')
                                                                                              , if (
                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                  , concat('belakang', ' - ', 'kembang')
                                                                                                  , if (
                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                      , concat('belakang', ' - ', 'kempis')
                                                                                                      , if (
                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                          , concat('belakang', ' - ', 'kembar')
                                                                                                          , if (
                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                              , concat('tengah', ' - ', 'stereo')
                                                                                                              , if (
                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                  , concat('tengah', ' - ', 'mono')
                                                                                                                  , if (
                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                      , concat('tengah', ' - ', 'kembang')
                                                                                                                      , if (
                                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                          , concat('tengah', ' - ', 'kempis')
                                                                                                                          , if (
                                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                              , concat('tengah', ' - ', 'kembar')
                                                                                                                              , if (
                                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                                                  , concat('depan', ' - ', 'stereo')
                                                                                                                                  , if (
                                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                                      , concat('depan', ' - ', 'mono')
                                                                                                                                      , if (
                                                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                                          , concat('depan', ' - ', 'kembang')
                                                                                                                                          , if (
                                                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                                              , concat('depan', ' - ', 'kempis')
                                                                                                                                              , if (
                                                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                                                  , concat('depan', ' - ', 'kembar')
                                                                                                                                                  , 'nulled'
                                                                                                                                              )
                                                                                                                                          )
                                                                                                                                      )
                                                                                                                                  )
                                                                                                                              )
                                                                                                                          )
                                                                                                                      )
                                                                                                                  )
                                                                                                              )
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                              )
                                                                                          )
                                                                                      )
                                                                                      , if (
                                                                                          togel_game.id = 12
                                                                                          , if (
                                                                                              bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                              , concat('belakang', '-', 'besar', '-', 'genap')
                                                                                              , if (
                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                  , concat('belakang', '-', 'besar', '-', 'ganjil')
                                                                                                  , if (
                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                      , concat('belakang', '-', 'kecil', '-', 'genap')
                                                                                                      , if (
                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                          , concat('belakang', '-', 'kecil', '-', 'ganjil')
                                                                                                          , if (
                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                              , concat('tengah', '-', 'besar', '-', 'genap')
                                                                                                              , if (
                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                  , concat('tengah', '-', 'besar', '-', 'ganjil')
                                                                                                                  , if (
                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                      , concat('tengah', '-', 'kecil', '-', 'genap')
                                                                                                                      , if (
                                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                          , concat('tengah', '-', 'kecil', '-', 'ganjil')
                                                                                                                          , if (
                                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                              , concat('depan', '-', 'besar', '-', 'genap')
                                                                                                                              , if (
                                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                                  , concat('depan', '-', 'besar', '-', 'ganjil')
                                                                                                                                  , if (
                                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                                      , concat('depan', '-', 'kecil', '-', 'genap')
                                                                                                                                      , if (
                                                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                                          , concat('depan', '-', 'kecil', '-', 'ganjil')
                                                                                                                                          , 'nulled'
                                                                                                                                      )
                                                                                                                                  )
                                                                                                                              )
                                                                                                                          )
                                                                                                                      )
                                                                                                                  )
                                                                                                              )
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                              )
                                                                                          )
                                                                                          , if (
                                                                                              togel_game.id = 13
                                                                                              , if (
                                                                                                  bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                  , 'genap'
                                                                                                  , if (
                                                                                                      bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                      , 'ganjil'
                                                                                                      , if (
                                                                                                          bets_togel.tebak_besar_kecil = 'besar'
                                                                                                          , 'besar'
                                                                                                          , if (
                                                                                                              bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                              , 'kecil'
                                                                                                              , 'nulled'
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                              )
                                                                                              , if (
                                                                                                  togel_game.id = 14
                                                                                                  , togel_shio_name.name
                                                                                                  , 'nulled'
                                                                                              )
                                                                                          )
                                                                                      )
                                                                                  )
                                                                              )
                                                                          )
                                                                      )
                                                                  )
                                                              )
                                                          )
                                                      )
                                                  )
                                              )
                                          )
                                      )
                                  )
                              )
                          )
                      )
                  )
              ) as 'Nomor'
            ")
            ->where('bets_togel.updated_at', null)
            ->where('constant_provider_togel.id', $pasaran->id)
            ->where('bets_togel.togel_game_id', $game->id)
            ->where('bets_togel.number_3', $number_3)
            ->where('bets_togel.number_4', $number_4)
            ->where('bets_togel.number_5', $number_5)
            ->where('bets_togel.number_6', $number_6)
            ->where('bets_togel.tebak_as_kop_kepala_ekor', $tebak_as_kop_kepala_ekor)
            ->where('bets_togel.tebak_besar_kecil', $tebak_besar_kecil)
            ->where('bets_togel.tebak_genap_ganjil', $tebak_genap_ganjil)
            ->where('bets_togel.tebak_tengah_tepi', $tebak_tengah_tepi)
            ->where('bets_togel.tebak_depan_tengah_belakang', $tebak_depan_tengah_belakang)
            ->where('bets_togel.tebak_mono_stereo', $tebak_mono_stereo)
            ->where('bets_togel.tebak_kembang_kempis_kembar', $tebak_kembang_kempis_kembar)
            ->where('bets_togel.tebak_shio', $tebak_shio);

          if ($lastPeriod) {             
            $checkBetTogels->where('bets_togel.period', $lastPeriod->period)
            ->groupBy('bets_togel.togel_game_id');
          } else {
            $checkBetTogels->groupBy('bets_togel.togel_game_id');
          }
          $checkBetTogel = $checkBetTogels->first();
          
          if ($checkBetTogel == true) {
              if ($game->id == 1){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_4d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota4D = $settingGames->limit_total_4d - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '4D',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_4d,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota4D,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_3d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota3D = $settingGames->limit_total_3d - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '3D',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_3d,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota3D,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota2D = $settingGames->limit_total_2d - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_2d,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota2D,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] == null && $data['number_4'] != null && $data['number_3'] != null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d_depan'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota2DD = $settingGames->limit_total_2d_depan - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Depan',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_2d_depan,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota2DD,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d_tengah'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota2DT = $settingGames->limit_total_2d_tengah - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Tengah',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_2d_tengah,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota2DT,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                }
              } elseif ($game->id == 2){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_4d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota4D = $settingGames->limit_total_4d - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '4D Set',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_4d,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota4D,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_3d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota3D = $settingGames->limit_total_3d - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '3D Set',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_3d,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota3D,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota2D = $settingGames->limit_total_2d - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Set',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_2d,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota2D,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } 
              } elseif ($game->id == 3){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_4d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota4D = $settingGames->limit_total_4d - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '4D Bolak Balik',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_4d,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota4D,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_3d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota3D = $settingGames->limit_total_3d - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '3D Bolak Balik',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_3d,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota3D,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota2D = $settingGames->limit_total_2d - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Bolak Balik',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_2d,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota2D,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } 
              } elseif ($game->id == 4){          
                if ($data['number_6'] !== null && $data['number_5'] !== null && $data['number_4'] == null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota2D = $settingGames->limit_total_2d - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Quick2d',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_2d,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota2D,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] == null && $data['number_4'] !== null && $data['number_3'] !== null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d_depan'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota2DD = $settingGames->limit_total_2d_depan - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Depan Quick2d',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_2d_depan,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota2DD,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] !== null && $data['number_4'] !== null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d_tengah'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $sisaQuota2DT = $settingGames->limit_total_2d_tengah - $checkBetTogel->totalBet;
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Tengah Quick2d',
                      'nomor' => $checkBetTogel->Nomor,
                      'total-limit' => $settingGames->limit_total_2d_tengah,
                      'limit-terpakai' => $checkBetTogel->totalBet,
                      'sisaQuota' => $sisaQuota2DT,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                }
              } else {
                $settingGames = TogelSettingGames::select(
                          'limit_total'
                        )
                        ->where('constant_provider_togel_id', $pasaran->id)
                        ->where('togel_game_id', $game->id)->first();
                $gameName =TogelGame::select('name')->where('id', $game->id)->first();
                $sisaQuota = $settingGames->limit_total - $checkBetTogel->totalBet;
                $result =  [
                  'status' => 'success',
                  'data'   =>[
                  'game' => $gameName->name,
                  'nomor' => $checkBetTogel->Nomor,
                  'total-limit' => $settingGames->limit_total,
                  'limit-terpakai' => $checkBetTogel->totalBet,
                  'sisaQuota' => $sisaQuota,
                  'bet' => $data['pay_amount'],
                  ]            
                ];
              } 
          } else {
              if ($game->id == 1){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_4d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '4D',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_4d,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_4d,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_3d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '3D',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_3d,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_3d,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_2d,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_2d,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] == null && $data['number_4'] != null && $data['number_3'] != null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d_depan'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Depan',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_2d_depan,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_2d_depan,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d_tengah'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Tengah',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_2d_tengah,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_2d_tengah,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                }
              } elseif ($game->id == 2){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_4d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '4D Set',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_4d,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_4d,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_3d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '3D Set',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_3d,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_3d,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Set',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_2d,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_2d,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } 
              } elseif ($game->id == 3){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_4d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '4D Bolak Balik',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_4d,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_4d,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_3d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '3D Bolak Balik',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_3d,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_3d,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Bolak Balik',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_2d,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_2d,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } 
              } elseif ($game->id == 4){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Quick2d',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_2d,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_2d,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] == null && $data['number_4'] != null && $data['number_3'] != null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d_depan'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Depan Quick2d',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_2d_depan,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_2d_depan,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null){
                  $settingGames = TogelSettingGames::select(
                                  'limit_total_2d_tengah'
                                )
                                ->where('constant_provider_togel_id', $pasaran->id)
                                ->where('togel_game_id', $game->id)->first();
                  $result =  [
                    'status' => 'success',
                    'data'   =>[
                      'game'  => '2D Tengah Quick2d',
                      'nomor' => null,
                      'total-limit' => $settingGames->limit_total_2d_tengah,
                      'limit-terpakai' => null,
                      'sisaQuota' => $settingGames->limit_total_2d_tengah,
                      'bet' => $data['pay_amount'],
                    ]            
                  ];
                }
              } else {
                $settingGames = TogelSettingGames::select(
                          'limit_total'
                        )
                        ->where('constant_provider_togel_id', $pasaran->id)
                        ->where('togel_game_id', $game->id)->first();
                $gameName =TogelGame::select('name')->where('id', $game->id)->first();
                $result =  [
                  'status' => 'success',
                  'data'   =>[
                  'game' => $gameName->name,
                  'nomor' => null,
                  'total-limit' => $settingGames->limit_total,
                  'limit-terpakai' => null,
                  'sisaQuota' => $settingGames->limit_total,
                  'bet' => $data['pay_amount'],
                  ]            
                ];
              }
          }

          $results[] = $result;
      }

      $data = [];
      foreach ($results as $key => $value) {
        if ($value['data']['bet'] > $value['data']['sisaQuota']) {
          $data[] = $value['data'];
        }
      }

      if ($data != []) {
        $sisaQuota = $data[0]['sisaQuota'] <= 0 ? "sisa quota sudah habis" : "sisa quota sebesar Rp. ". number_format($data[0]['sisaQuota']) ."";
        return "Over Kuota (sudah limit), ".$sisaQuota." untuk nomor ". $data[0]['nomor'] ." di Game ".$data[0]['game']."";
      }
      return false;      
    } catch (\Throwable $th) {
      return $this->errorResponse($th->getMessage(), 500);
    }
  }
}
