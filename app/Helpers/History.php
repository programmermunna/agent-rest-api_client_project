<?php  

namespace App\Helpers;

use App\Models\BetsTogel;

trait History 
{
	public function get()
	{
		return BetsTogel::join('members', 'bets_togel.created_by', '=', 'members.id')
			->join('constant_provider_togel', 'bets_togel.constant_provider_togel_id', '=', 'constant_provider_togel.id')
			->join('togel_game', 'bets_togel.togel_game_id', '=', 'togel_game.id')
			->leftJoin('togel_shio_name', 'bets_togel.tebak_shio', '=', 'togel_shio_name.id')
			->join('togel_setting_game', 'bets_togel.togel_setting_game_id', '=', 'togel_setting_game.id')
			->selectRaw("
                bets_togel.id,
                constant_provider_togel.id as constant_provider_togel_id,
                bets_togel.created_at
                
                , members.last_login_ip as 'IP'
                , members.username as 'Username'
                , concat(constant_provider_togel.name_initial, '-', constant_provider_togel.period) as 'Pasaran'
                , if (
                    bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                    , '4D'
                    , if (
                        bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1 
                        , '3D'
                        , if (
                            bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                            , '2D'
                            , if (
                                bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                                , '2D Tengah'
                                , if (
                                    bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                                    , '2D Depan'
                                    , togel_game.name
                                )
                            )
                        )
                    )
                ) as 'Game'
                , if (
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
                                                        , concat(bets_togel.number_1, bets_togel.number_2)
                                                        , if (
                                                            togel_game.id = 7
                                                            , concat(bets_togel.number_1, bets_togel.number_2, bets_togel.number_3)
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
                , bets_togel.bet_amount as 'Bet'
                , bets_togel.pay_amount as 'Bayar'
                , concat(floor(bets_togel.tax_amount), '%') as 'disc/kei'
                
                , if (
                    bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                    , concat(floor(togel_setting_game.win_4d_x), 'x')
                    , if (
                        bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                        , concat(floor(togel_setting_game.win_3d_x), 'x')
                        , if (
                            bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                            , concat(floor(togel_setting_game.win_2d_x), 'x')
                            , if (
                                bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                , concat(floor(togel_setting_game.win_2d_tengah_x), 'x')
                                , if (
                                    bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                    , concat(floor(togel_setting_game.win_2d_depan_x), 'x')
                                    , if (
                                        togel_game.id = 5
                                        , concat(floor(togel_setting_game.win_x), 'x')
                                        , if (
                                            togel_game.id = 6
                                            , concat(floor(togel_setting_game.win_2_digit), '/', floor(togel_setting_game.win_3_digit), '/', floor(togel_setting_game.win_4_digit), 'x')
                                            , if (
                                                togel_game.id = 7
                                                , concat(floor(togel_setting_game.win_3_digit), '/', floor(togel_setting_game.win_4_digit), 'x')
                                                , if (
                                                    togel_game.id = 8
                                                    , concat(if (
                                                        bets_togel.tebak_as_kop_kepala_ekor = 'as'
                                                        , concat(floor(togel_setting_game.win_as), 'x')
                                                        , if (
                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kop'
                                                            , concat(floor(togel_setting_game.win_kop), 'x')
                                                            , if (
                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kepala'
                                                                , concat(floor(togel_setting_game.win_kepala), 'x')
                                                                , if (
                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'ekor'
                                                                    , concat(floor(togel_setting_game.win_ekor), 'x')
                                                                    , 'nulled'
                                                                )
                                                            )
                                                        )
                                                    ))
                                                    , if (
                                                        togel_game.id = 9
                                                        , if (
                                                            bets_togel.tebak_besar_kecil is null
                                                            , if (
                                                                bets_togel.tebak_genap_ganjil is null
                                                                , if (
                                                                    bets_togel.tebak_tengah_tepi is null
                                                                    , 'nulled'
                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                )
                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                            )
                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                        )
                                                        , if (
                                                            togel_game.id = 10
                                                            , if (
                                                                bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                , if (
                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                    , if (
                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                        , if (
                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , if (
                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                        , if (
                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                            , if (
                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                , if (
                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                        , if (
                                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
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
                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                    , if (
                                                                        bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'mono'
                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                        , if (
                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , if (
                                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                        , if (
                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                            , if (
                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                , if (
                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                        , if (
                                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
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
                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                        , if (
                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , if (
                                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                        , if (
                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                            , if (
                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                , if (
                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
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
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , if (
                                                                                bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_besar_kecil = 'besar'
                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_besar_kecil = 'kecil'
                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                        , 'nulled'
                                                                                    )
                                                                                )
                                                                            )
                                                                        )
                                                                        , if (
                                                                            togel_game.id = 14
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
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
                ) as 'Win'
                , if (
                    bets_togel.updated_at is null
                    , 'Running'
                    , if (
                        bets_togel.win_lose_status = 1
                        , 'Win'
                        , 'Lose'
                    )
                ) as 'Status'
            ");
	}
}
