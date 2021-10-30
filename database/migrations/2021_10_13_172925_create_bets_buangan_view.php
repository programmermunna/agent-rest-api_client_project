<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetsBuanganView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP VIEW IF EXISTS bets_buangan');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function createView()
    {
        return "
        DROP VIEW IF EXISTS bets_buangan;
        CREATE VIEW bets_buangan AS
            select
            a.id
            , concat(b.name_initial, '-', b.period) as 'Pasaran'
            , b.id as 'pasaran_filter'
            , if (
                a.number_6 is not null and a.number_5 is not null and a.number_4 is not null and a.number_3 is not null and a.number_2 is null and a.number_1 is null
                , '4D'
                , if (
                    a.number_6 is not null and a.number_5 is not null and a.number_4 is not null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                    , '3D'
                    , if (
                        a.number_6 is not null and a.number_5 is not null and a.number_4 is null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                        , '2D'
                        , if (
                            a.number_6 is null and a.number_5 is not null and a.number_4 is not null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                            , '2D Tengah'
                            , if (
                                a.number_6 is null and a.number_5 is null and a.number_4 is not null and a.number_3 is not null and a.number_2 is null and a.number_1 is null
                                , '2D Depan'
                                , c.name
                            )
                        )
                    )
                )
            ) as 'Game'
            , c.id as 'game_id_filter'
            , if (
            a.number_6 is not null and a.number_5 is not null and a.number_4 is not null and a.number_3 is not null and a.number_2 is null and a.number_1 is null
            , concat(a.number_3, a.number_4, a.number_5, a.number_6)
            , if (
                a.number_6 is not null and a.number_5 is not null and a.number_4 is not null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                , concat(a.number_4, a.number_5, a.number_6)
                , if (
                    a.number_6 is not null and a.number_5 is not null and a.number_4 is null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                    , concat(a.number_5, a.number_6)
                    , if (
                        a.number_6 is null and a.number_5 is not null and a.number_4 is not null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                        , concat(a.number_4, a.number_5)
                        , if (
                            a.number_6 is null and a.number_5 is null and a.number_4 is not null and a.number_3 is not null and a.number_2 is null and a.number_1 is null
                            , concat(a.number_3, a.number_4)
                            , if (
                                c.id = 5
                                , a.number_6
                                , if (
                                    c.id = 6
                                    , concat(a.number_5, a.number_6)
                                    , if (
                                        c.id = 7
                                        , concat(a.number_4, a.number_5, a.number_6)
                                        , if (
                                            c.id = 8
                                            , concat(a.number_6, ' - ' , a.tebak_as_kop_kepala_ekor)
                                            , if (
                                                c.id = 9
                                                , if (
                                                    a.tebak_besar_kecil is null
                                                    , if (
                                                        a.tebak_genap_ganjil is null
                                                        , if (
                                                            a.tebak_tengah_tepi is null
                                                            , 'nulled'
                                                            , a.tebak_tengah_tepi
                                                        )
                                                        , a.tebak_genap_ganjil
                                                    )
                                                    , a.tebak_besar_kecil
                                                )
                                                , if (
                                                    c.id = 10
                                                    , if (
                                                        a.tebak_as_kop_kepala_ekor = 'as' and a.tebak_genap_ganjil = 'genap'
                                                        , concat('as', '-', 'genap')
                                                        , if (
                                                            a.tebak_as_kop_kepala_ekor = 'as' and a.tebak_genap_ganjil = 'ganjil'
                                                            , concat('as', '-', 'ganjil')
                                                            , if (
                                                                a.tebak_as_kop_kepala_ekor = 'kop' and a.tebak_genap_ganjil = 'genap'
                                                                , concat('kop', '-', 'genap')
                                                                , if (
                                                                    a.tebak_as_kop_kepala_ekor = 'kop' and a.tebak_genap_ganjil = 'ganjil'
                                                                    , concat('kop', '-', 'ganjil')
                                                                    , if (
                                                                        a.tebak_as_kop_kepala_ekor = 'kepala' and a.tebak_genap_ganjil = 'genap'
                                                                        , concat('kepala', '-', 'genap')
                                                                        , if (
                                                                            a.tebak_as_kop_kepala_ekor = 'kepala' and a.tebak_genap_ganjil = 'ganjil'
                                                                            , concat('kepala', '-', 'ganjil')
                                                                            , if (
                                                                                a.tebak_as_kop_kepala_ekor = 'ekor' and a.tebak_genap_ganjil = 'genap'
                                                                                , concat('ekor', '-', 'genap')
                                                                                , if (
                                                                                    a.tebak_as_kop_kepala_ekor = 'ekor' and a.tebak_genap_ganjil = 'ganjil'
                                                                                    , concat('ekor', '-', 'ganjil')
                                                                                    , if (
                                                                                        a.tebak_as_kop_kepala_ekor = 'as' and a.tebak_besar_kecil = 'besar'
                                                                                        , concat('as', '-', 'besar')
                                                                                        , if (
                                                                                            a.tebak_as_kop_kepala_ekor = 'as' and a.tebak_besar_kecil = 'kecil'
                                                                                            , concat('as', '-', 'kecil')
                                                                                            , if (
                                                                                                a.tebak_as_kop_kepala_ekor = 'kop' and a.tebak_besar_kecil = 'besar'
                                                                                                , concat('kop', '-', 'besar')
                                                                                                , if (
                                                                                                    a.tebak_as_kop_kepala_ekor = 'kop' and a.tebak_besar_kecil = 'kecil'
                                                                                                    , concat('kop', '-', 'kecil')
                                                                                                    , if (
                                                                                                        a.tebak_as_kop_kepala_ekor = 'kepala' and a.tebak_besar_kecil = 'besar'
                                                                                                        , concat('kepala', '-', 'besar')
                                                                                                        , if (
                                                                                                            a.tebak_as_kop_kepala_ekor = 'kepala' and a.tebak_besar_kecil = 'kecil'
                                                                                                            , concat('kepala', '-', 'kecil')
                                                                                                            , if (
                                                                                                                a.tebak_as_kop_kepala_ekor = 'ekor' and a.tebak_besar_kecil = 'besar'
                                                                                                                , concat('ekor', '-', 'besar')
                                                                                                                , if (
                                                                                                                    a.tebak_as_kop_kepala_ekor = 'ekor' and a.tebak_besar_kecil = 'kecil'
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
                                                        c.id = 11
                                                        , if (
                                                            a.tebak_depan_tengah_belakang = 'belakang' and a.tebak_mono_stereo = 'stereo'
                                                            , concat('belakang', ' - ', 'stereo')
                                                            , if (
                                                                a.tebak_depan_tengah_belakang = 'belakang' and a.tebak_mono_stereo = 'mono'
                                                                , concat('belakang', ' - ', 'mono')
                                                                , if (
                                                                    a.tebak_depan_tengah_belakang = 'belakang' and a.tebak_kembang_kempis_kembar = 'kembang'
                                                                    , concat('belakang', ' - ', 'kembang')
                                                                    , if (
                                                                        a.tebak_depan_tengah_belakang = 'belakang' and a.tebak_kembang_kempis_kembar = 'kempis'
                                                                        , concat('belakang', ' - ', 'kempis')
                                                                        , if (
                                                                            a.tebak_depan_tengah_belakang = 'belakang' and a.tebak_kembang_kempis_kembar = 'kembar'
                                                                            , concat('belakang', ' - ', 'kembar')
                                                                            , if (
                                                                                a.tebak_depan_tengah_belakang = 'tengah' and a.tebak_mono_stereo = 'stereo'
                                                                                , concat('tengah', ' - ', 'stereo')
                                                                                , if (
                                                                                    a.tebak_depan_tengah_belakang = 'tengah' and a.tebak_mono_stereo = 'mono'
                                                                                    , concat('tengah', ' - ', 'mono')
                                                                                    , if (
                                                                                        a.tebak_depan_tengah_belakang = 'tengah' and a.tebak_kembang_kempis_kembar = 'kembang'
                                                                                        , concat('tengah', ' - ', 'kembang')
                                                                                        , if (
                                                                                            a.tebak_depan_tengah_belakang = 'tengah' and a.tebak_kembang_kempis_kembar = 'kempis'
                                                                                            , concat('tengah', ' - ', 'kempis')
                                                                                            , if (
                                                                                                a.tebak_depan_tengah_belakang = 'tengah' and a.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                , concat('tengah', ' - ', 'kembar')
                                                                                                , if (
                                                                                                    a.tebak_depan_tengah_belakang = 'depan' and a.tebak_mono_stereo = 'stereo'
                                                                                                    , concat('depan', ' - ', 'stereo')
                                                                                                    , if (
                                                                                                        a.tebak_depan_tengah_belakang = 'depan' and a.tebak_mono_stereo = 'mono'
                                                                                                        , concat('depan', ' - ', 'mono')
                                                                                                        , if (
                                                                                                            a.tebak_depan_tengah_belakang = 'depan' and a.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                            , concat('depan', ' - ', 'kembang')
                                                                                                            , if (
                                                                                                                a.tebak_depan_tengah_belakang = 'depan' and a.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                , concat('depan', ' - ', 'kempis')
                                                                                                                , if (
                                                                                                                    a.tebak_depan_tengah_belakang = 'depan' and a.tebak_kembang_kempis_kembar = 'kembar'
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
                                                            c.id = 12
                                                            , if (
                                                                a.tebak_depan_tengah_belakang = 'belakang' and a.tebak_besar_kecil = 'besar' and a.tebak_genap_ganjil = 'genap'
                                                                , concat('belakang', '-', 'besar', '-', 'genap')
                                                                , if (
                                                                    a.tebak_depan_tengah_belakang = 'belakang' and a.tebak_besar_kecil = 'besar' and a.tebak_genap_ganjil = 'ganjil'
                                                                    , concat('belakang', '-', 'besar', '-', 'ganjil')
                                                                    , if (
                                                                        a.tebak_depan_tengah_belakang = 'belakang' and a.tebak_besar_kecil = 'kecil' and a.tebak_genap_ganjil = 'genap'
                                                                        , concat('belakang', '-', 'kecil', '-', 'genap')
                                                                        , if (
                                                                            a.tebak_depan_tengah_belakang = 'belakang' and a.tebak_besar_kecil = 'kecil' and a.tebak_genap_ganjil = 'ganjil'
                                                                            , concat('belakang', '-', 'kecil', '-', 'ganjil')
                                                                            , if (
                                                                                a.tebak_depan_tengah_belakang = 'tengah' and a.tebak_besar_kecil = 'besar' and a.tebak_genap_ganjil = 'genap'
                                                                                , concat('tengah', '-', 'besar', '-', 'genap')
                                                                                , if (
                                                                                    a.tebak_depan_tengah_belakang = 'tengah' and a.tebak_besar_kecil = 'besar' and a.tebak_genap_ganjil = 'ganjil'
                                                                                    , concat('tengah', '-', 'besar', '-', 'ganjil')
                                                                                    , if (
                                                                                        a.tebak_depan_tengah_belakang = 'tengah' and a.tebak_besar_kecil = 'kecil' and a.tebak_genap_ganjil = 'genap'
                                                                                        , concat('tengah', '-', 'kecil', '-', 'genap')
                                                                                        , if (
                                                                                            a.tebak_depan_tengah_belakang = 'tengah' and a.tebak_besar_kecil = 'kecil' and a.tebak_genap_ganjil = 'ganjil'
                                                                                            , concat('tengah', '-', 'kecil', '-', 'ganjil')
                                                                                            , if (
                                                                                                a.tebak_depan_tengah_belakang = 'depan' and a.tebak_besar_kecil = 'besar' and a.tebak_genap_ganjil = 'genap'
                                                                                                , concat('depan', '-', 'besar', '-', 'genap')
                                                                                                , if (
                                                                                                    a.tebak_depan_tengah_belakang = 'depan' and a.tebak_besar_kecil = 'besar' and a.tebak_genap_ganjil = 'ganjil'
                                                                                                    , concat('depan', '-', 'besar', '-', 'ganjil')
                                                                                                    , if (
                                                                                                        a.tebak_depan_tengah_belakang = 'depan' and a.tebak_besar_kecil = 'kecil' and a.tebak_genap_ganjil = 'genap'
                                                                                                        , concat('depan', '-', 'kecil', '-', 'genap')
                                                                                                        , if (
                                                                                                            a.tebak_depan_tengah_belakang = 'depan' and a.tebak_besar_kecil = 'kecil' and a.tebak_genap_ganjil = 'ganjil'
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
                                                                c.id = 13
                                                                , if (
                                                                    a.tebak_genap_ganjil = 'genap'
                                                                    , 'genap'
                                                                    , if (
                                                                        a.tebak_genap_ganjil = 'ganjil'
                                                                        , 'ganjil'
                                                                        , if (
                                                                            a.tebak_besar_kecil = 'besar'
                                                                            , 'besar'
                                                                            , if (
                                                                                a.tebak_besar_kecil = 'kecil'
                                                                                , 'kecil'
                                                                                , 'nulled'
                                                                            )
                                                                        )
                                                                    )
                                                                )
                                                                , if (
                                                                    c.id = 14
                                                                    , d.name
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
            ) as 'Nomor'
            , a.bet_amount  as 'Bet'
            , if (
                c.id = 1
                , if (
                    a.number_6 is not null and a.number_5 is not null and a.number_4 is not null and a.number_3 is not null and a.number_2 is null and a.number_1 is null
                    , e.limit_buang_4d
                    , if (
                        a.number_6 is not null and a.number_5 is not null and a.number_4 is not null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                        , e.limit_buang_3d
                        , if (
                            a.number_6 is not null and a.number_5 is not null and a.number_4 is null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                            , e.limit_buang_2d
                            , if (
                                a.number_6 is null and a.number_5 is not null and a.number_4 is not null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                                , e.limit_buang_2d_tengah
                                , if (
                                    a.number_6 is null and a.number_5 is null and a.number_4 is not null and a.number_3 is not null and a.number_2 is null and a.number_1 is null
                                    , e.limit_buang_2d_depan
                                    , 'nulled'
                                )
                            )
                        )
                    )
                )
                , if (
                    c.id = 5 or c.id = 6 or c.id = 7 or c.id = 8 or c.id = 9 or c.id = 10 or c.id = 11 or c.id = 12 or c.id = 13 or c.id = 14
                    , e.limit_buang
                    , 'nulled'
                )
            ) as 'limit_bet'
            , 0 as 'buangan_terpasang'
            , a.buangan_before_submit as 'sisa_buangan'
            , if (
                a.buangan_terpasang_by is null
                , 'RUNNING'
                , if (
                    a.buangan_terpasang_by is not null and a.is_bets_buangan_terpasang = 1
                    , 'RUNNING'
                    , 'nulled'
                )
            ) as 'status'
            from
            bets_togel a
            join constant_provider_togel b on a.constant_provider_togel_id = b.id
            join togel_game c on a.togel_game_id = c.id
            left join togel_shio_name d on a.tebak_shio = d.id
            join togel_setting_game e on a.togel_setting_game_id = e.id
            join constant_provider_togel_wl f on b.name_initial = f.name_initial and b.name = f.name
            where a.is_bets_buangan = 1";
    }
}
