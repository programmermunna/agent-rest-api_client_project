<?php

namespace App\Http\Controllers;

use App\Models\ConstantProviderTogelModel;
use App\Models\TogelGame;
use App\Models\BetsTogel;
use App\Models\TogelSettingGames;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TogelSettingGameController extends ApiController
{
  public function getTogelSettingGame(Request $request)
  {
    
    $validator = Validator::make($request->all(),[
      'type'  => 'required',
      'provider' => 'required|numeric'
    ]);

    if($validator->fails()){
      return $this->errorResponse('Validation Error', 422, $validator->errors()->first());
    }

    switch ($request->type) {
      case 'normal':
        return TogelSettingGames::query()->normal([1, 2, 3, 4], $request->provider)->get();
        break;
      case 'colok':
        return TogelSettingGames::query()->colokjitu([5, 6, 7, 8], $request->provider)->get();
        break;
      case '50:50':
        return TogelSettingGames::query()->fifty([9, 10, 11], $request->provider)->get();
        break;
      case 'lain-lain':
        return TogelSettingGames::query()->colokjitu([12, 13, 14], $request->provider)->get();
        break;
      default:
        return response('Missing Type');
        break;
    }
  }

  public function sisaQuota(Request $request){
    try {

      $pasaran = ConstantProviderTogelModel::select(['id','name'])->where('name', $request->pasaran)->first();
      $game    = TogelGame::select(['id','name'])->where('name', $request->game)->first();
      if(is_null($pasaran)){
        return $this->errorResponse('Pasaran name does not match', 400);
      }
      if(is_null($game)){
        return $this->errorResponse('Game name does not match', 400);
      }
      $lastPeriod = BetsTogel::select('period')->latest()->firstOrFail();
      $results = [];
      foreach ($request->data as $key => $data) {
        $checkBetTogel = BetsTogel::join('members', 'bets_togel.created_by', '=', 'members.id')  
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
            ->where('bets_togel.period', $lastPeriod->period)
            ->where('constant_provider_togel.id', $pasaran->id)
            ->where('bets_togel.togel_game_id', $game->id)
            ->where('bets_togel.number_1', $data['number_1'])
            ->where('bets_togel.number_2', $data['number_2'])
            ->where('bets_togel.number_3', $data['number_3'])
            ->where('bets_togel.number_4', $data['number_4'])
            ->where('bets_togel.number_5', $data['number_5'])
            ->where('bets_togel.number_6', $data['number_6'])
            ->where('bets_togel.tebak_as_kop_kepala_ekor', $data['tebak_as_kop_kepala_ekor'])
            ->where('bets_togel.tebak_besar_kecil', $data['tebak_besar_kecil'])
            ->where('bets_togel.tebak_genap_ganjil', $data['tebak_genap_ganjil'])
            ->where('bets_togel.tebak_tengah_tepi', $data['tebak_tengah_tepi'])
            ->where('bets_togel.tebak_depan_tengah_belakang', $data['tebak_depan_tengah_belakang'])
            ->where('bets_togel.tebak_mono_stereo', $data['tebak_mono_stereo'])
            ->where('bets_togel.tebak_kembang_kempis_kembar', $data['tebak_kembang_kempis_kembar'])
            ->where('bets_togel.tebak_shio', $data['tebak_shio'])
            ->groupBy('bets_togel.togel_game_id')->first();

            // dd($checkBetTogel);

            if ($checkBetTogel == true) {
              if ($game->id == 1){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] == null && $data['number_4'] != null && $data['number_3'] != null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                }
              } elseif ($game->id == 2){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } 
              } elseif ($game->id == 3){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } 
              } elseif ($game->id == 4){          
                if ($data['number_6'] !== null && $data['number_5'] !== null && $data['number_4'] == null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] == null && $data['number_4'] !== null && $data['number_3'] !== null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] !== null && $data['number_4'] !== null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                }
              } else {
                $settingGames = TogelSettingGames::select(
                          'limit_total'
                        )
                        ->where('constant_provider_togel_id', $pasaran->id)
                        ->where('togel_game_id', $game->id)->first();
                $game =TogelGame::select('name')->where('id', $game->id)->first();
                $sisaQuota = $settingGames->limit_total - $checkBetTogel->totalBet;
                $result =  [
                  'status' => 'success',
                  'data'   =>[
                  'game' => $game->name,
                  'nomor' => $checkBetTogel->Nomor,
                  'total-limit' => $settingGames->limit_total,
                  'limit-terpakai' => $checkBetTogel->totalBet,
                  'sisaQuota' => $sisaQuota,
                  ]            
                ];
              } 
            } else {
              if ($game->id == 1){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] == null && $data['number_4'] != null && $data['number_3'] != null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                }
              } elseif ($game->id == 2){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } 
              } elseif ($game->id == 3){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] != null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } 
              } elseif ($game->id == 4){
                if ($data['number_6'] != null && $data['number_5'] != null && $data['number_4'] == null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] == null && $data['number_4'] != null && $data['number_3'] != null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                } elseif ($data['number_6'] == null && $data['number_5'] != null && $data['number_4'] != null && $data['number_3'] == null && $data['number_2'] == null && $data['number_1'] == null){
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
                    ]            
                  ];
                }
              } else {
                $settingGames = TogelSettingGames::select(
                          'limit_total'
                        )
                        ->where('constant_provider_togel_id', $pasaran->id)
                        ->where('togel_game_id', $game->id)->first();
                $game =TogelGame::select('name')->where('id', $game->id)->first();
                $result =  [
                  'status' => 'success',
                  'data'   =>[
                  'game' => $game->name,
                  'nomor' => null,
                  'total-limit' => $settingGames->limit_total,
                  'limit-terpakai' => null,
                  'sisaQuota' => $settingGames->limit_total,
                  ]            
                ];
              }
            }

            $results[] = $result;
      }

      return $this->successResponse($results);

      
    } catch (\Throwable $th) {
      return $this->errorResponse($th->getMessage(), 500);
    }
  }

  /**
   * Get Global Setting Games 
   */
  public function getGlobalSettingGame(Request $request)
  {
    $provider = $request->provider;

    if (!isset($provider) && empty($provider)) {
      return response()->json([
        'code' => 422,
        'message' => 'Hmm provider and type of game must exist on params'
      ]);
    }

    $settingGames = TogelSettingGames::query()
      ->addSelect([
        'togel_game' => TogelGame::select('name')->whereColumn('togel_game.id', 'togel_setting_game.togel_game_id')
      ])
      ->whereHas('constant_provider_togel', function ($value) use ($provider) {
        $value
          ->where('name', $provider);
      })
      ->latest()
      ->orderBy('id', 'desc')
      ->get();

    return $settingGames;
  }
}
