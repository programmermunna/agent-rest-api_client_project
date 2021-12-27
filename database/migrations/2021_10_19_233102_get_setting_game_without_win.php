<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GetSettingGameWithoutWin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
            DROP PROCEDURE IF EXISTS `get_setting_game_without_win`;
            CREATE PROCEDURE `get_setting_game_without_win`(IN `optional` varchar(100), IN `constant_provider_togel_id` bigint(20), IN `togel_game_id` bigint(20), IN `type` varchar(20))
            BEGIN
            /*4D*/
            /*id: 1,2,3,4*/
            /*disc_4d*/
            SET @_KOLOM = '';
            SET @_MIN_BET = '';
            SET @_MAX_BET = '';
            SET @_WIN = '';
            SET @_LIMIT_BUANG = '';
            if (togel_game_id = 1 or togel_game_id = 2 or togel_game_id = 3 or togel_game_id = 4) and type = '4d' then
            begin
                SET @_KOLOM = 'disc_4d';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet_4d';
                SET @_WIN = 'win_4d_x';
                SET @_LIMIT_BUANG = 'limit_buang_4d';
            end;
            end if;

            /*3D*/
            /*id: 1,2,3,4*/
            /*disc_3d*/
            if (togel_game_id = 1 or togel_game_id = 2 or togel_game_id = 3 or togel_game_id = 4) and type = '3d' then
            begin
                SET @_KOLOM = 'disc_3d';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet_3d';
                SET @_WIN = 'win_3d_x';
                SET @_LIMIT_BUANG = 'limit_buang_3d';
            end;
            end if;

            /*2D*/
            /*id: 1,2,3,4*/
            /*disc_2d*/
            if (togel_game_id = 1 or togel_game_id = 2 or togel_game_id = 3 or togel_game_id = 4) and type = '2d' then
            begin
                SET @_KOLOM = 'disc_2d';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet_2d';
                SET @_WIN = 'win_2d_x';
                SET @_LIMIT_BUANG = 'limit_buang_2d';
            end;
            end if;

            /*2D Depan*/
            /*id: 1,2,3,4*/
            /*disc_2d_depan*/
            if (togel_game_id = 1 or togel_game_id = 2 or togel_game_id = 3 or togel_game_id = 4) and type = '2d_depan' then
            begin
                SET @_KOLOM = 'disc_2d_depan';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet_2d_depan';
                SET @_WIN = 'win_2d_depan_x';
                SET @_LIMIT_BUANG = 'limit_buang_2d_depan';
            end;
            end if;

            /*2D Tengah*/
            /*id: 1,2,3,4*/
            /*disc_2d_tengah*/
            if (togel_game_id = 1 or togel_game_id = 2 or togel_game_id = 3 or togel_game_id = 4) and type = '2d_tengah' then
            begin
                SET @_KOLOM = 'disc_2d_tengah';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet_2d_tengah';
                SET @_WIN = 'win_2d_tengah_x';
                SET @_LIMIT_BUANG = 'limit_buang_2d_tengah';
            end;
            end if;

            /*colok bebas*/
            /*id: 5*/
            /*disc*/
            if (togel_game_id = 5) and type = 'none' then
            begin
                SET @_KOLOM = 'disc';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = 'win_x';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;

            end if;

            /*colok macau*/
            /*id: 6*/
            /*disc*/
            if (togel_game_id = 6) and type = 'none' then
            begin
                SET @_KOLOM = 'disc';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;

            end if;

            /*colok naga*/
            /*id: 7*/
            /*disc*/
            if (togel_game_id = 7) and type = 'none' then
            begin
                SET @_KOLOM = 'disc';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;

            /*colok jitu*/
            /*id: 8*/
            /*disc*/
            if (togel_game_id = 8) and type = 'none' then
            begin
                SET @_KOLOM = 'disc';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;

            /*5050 umum*/
            /*id: 9*/
            /*
            kei_besar
            , kei_kecil
            , kei_genap
            , kei_ganjil
            , kei_tengah
            , kei_tepi
            */
            if (togel_game_id = 9) and type = 'none' and optional = 'besar' then
            begin
                SET @_KOLOM = 'kei_besar';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 9) and type = 'none' and optional = 'kecil' then
            begin
                SET @_KOLOM = 'kei_kecil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 9) and type = 'none' and optional = 'genap' then
            begin
                SET @_KOLOM = 'kei_genap';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 9) and type = 'none' and optional = 'ganjil' then
            begin
                SET @_KOLOM = 'kei_ganjil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 9) and type = 'none' and optional = 'tengah' then
            begin
                SET @_KOLOM = 'kei_tengah';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 9) and type = 'none' and optional = 'tepi' then
            begin
                SET @_KOLOM = 'kei_tepi';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;

            /*5050 special*/
            /*id: 10*/
            /*
            kei_as_genap
            , kei_as_ganjil
            , kei_as_besar
            , kei_as_kecil
            , kei_kop_genap
            , kei_kop_ganjil
            , kei_kop_besar
            , kei_kop_kecil
            , kei_kepala_genap
            , kei_kepala_ganjil
            , kei_kepala_besar
            , kei_kepala_kecil
            , kei_ekor_genap
            , kei_ekor_ganjil
            , kei_ekor_besar
            , kei_ekor_kecil
            */

            if (togel_game_id = 10) and type = 'none' and optional = 'as_genap' then
            begin
                SET @_KOLOM = 'kei_as_genap';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'as_ganjil' then
            begin
                SET @_KOLOM = 'kei_as_ganjil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'as_besar' then
            begin
                SET @_KOLOM = 'kei_as_besar';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'as_kecil' then
            begin
                SET @_KOLOM = 'kei_as_kecil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'kop_genap' then
            begin
                SET @_KOLOM = 'kei_kop_genap';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'kop_ganjil' then
            begin
                SET @_KOLOM = 'kei_kop_ganjil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'kop_besar' then
            begin
                SET @_KOLOM = 'kei_kop_besar';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'kop_kecil' then
            begin
                SET @_KOLOM = 'kei_kop_kecil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'kepala_genap' then
            begin
                SET @_KOLOM = 'kei_kepala_genap';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'kepala_ganjil' then
            begin
                SET @_KOLOM = 'kei_kepala_ganjil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'kepala_besar' then
            begin
                SET @_KOLOM = 'kei_kepala_besar';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'kepala_kecil' then
            begin
                SET @_KOLOM = 'kei_kepala_kecil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'ekor_genap' then
            begin
                SET @_KOLOM = 'kei_ekor_genap';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'ekor_ganjil' then
            begin
                SET @_KOLOM = 'kei_ekor_ganjil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'ekor_besar' then
            begin
                SET @_KOLOM = 'kei_ekor_besar';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 10) and type = 'none' and optional = 'ekor_kecil' then
            begin
                SET @_KOLOM = 'kei_ekor_kecil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;




            /*5050 kombinasi*/
            /*id: 11*/
            /*
            belakang_kei_mono
            , belakang_kei_stereo
            , belakang_kei_kembang
            , belakang_kei_kempis
            , belakang_kei_kembar
            , tengah_kei_mono
            , tengah_kei_stereo
            , tengah_kei_kembang
            , tengah_kei_kempis
            , tengah_kei_kembar
            , depan_kei_mono
            , depan_kei_stereo
            , depan_kei_kembang
            , depan_kei_kempis
            , depan_kei_kembar
            */

            if (togel_game_id = 11) and type = 'none' and optional = 'belakang_mono' then
            begin
                SET @_KOLOM = 'belakang_kei_mono';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'belakang_stereo' then
            begin
                SET @_KOLOM = 'belakang_kei_stereo';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'belakang_kembang' then
            begin
                SET @_KOLOM = 'belakang_kei_kembang';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'belakang_kempis' then
            begin
                SET @_KOLOM = 'belakang_kei_kempis';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'belakang_kembar' then
            begin
                SET @_KOLOM = 'belakang_kei_kembar';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'tengah_mono' then
            begin
                SET @_KOLOM = 'tengah_kei_mono';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'tengah_stereo' then
            begin
                SET @_KOLOM = 'tengah_kei_stereo';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'tengah_kembang' then
            begin
                SET @_KOLOM = 'tengah_kei_kembang';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'tengah_kempis' then
            begin
                SET @_KOLOM = 'tengah_kei_kempis';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'tengah_kembar' then
            begin
                SET @_KOLOM = 'tengah_kei_kembar';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'depan_mono' then
            begin
                SET @_KOLOM = 'depan_kei_mono';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'depan_stereo' then
            begin
                SET @_KOLOM = 'depan_kei_stereo';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'depan_kembang' then
            begin
                SET @_KOLOM = 'depan_kei_kembang';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'depan_kempis' then
            begin
                SET @_KOLOM = 'depan_kei_kempis';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 11) and type = 'none' and optional = 'depan_kembar' then
            begin
                SET @_KOLOM = 'depan_kei_kembar';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;


            /*lain lain kombinasi*/
            /*id: 12*/
            /*
            disc
            */
            if (togel_game_id = 12) and type = 'none' and optional = 'none' then
            begin
                SET @_KOLOM = 'disc';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;

            /*lain lain dasar*/
            /*id: 13*/
            /*
            kei_besar
            , kei_kecil
            , kei_genap
            , kei_ganjil
            */
            if (togel_game_id = 13) and type = 'none' and optional = 'besar' then
            begin
                SET @_KOLOM = 'kei_besar';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 13) and type = 'none' and optional = 'kecil' then
            begin
                SET @_KOLOM = 'kei_kecil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 13) and type = 'none' and optional = 'genap' then
            begin
                SET @_KOLOM = 'kei_genap';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;
            if (togel_game_id = 13) and type = 'none' and optional = 'ganjil' then
            begin
                SET @_KOLOM = 'kei_ganjil';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;

            /*lain lain shio*/
            /*id: 14*/
            /*
            disc
            */
            if (togel_game_id = 14) and type = 'none' and optional = 'none' then
            begin

                SET @_KOLOM = 'disc';
                SET @_MIN_BET = 'min_bet';
                SET @_MAX_BET = 'max_bet';
                SET @_WIN = '';
                SET @_LIMIT_BUANG = 'limit_buang';
            end;
            end if;



            /*select * from togel_game a order by a.id desc;*/

            /*SET @kolom = 'belakang_kei_kembar';
            SET @constant_provider_togel_id = 1;
            SET @togel_game_id = 11;*/

            SET @query = concat('
            select
            ', @_KOLOM, '
            , ', @_MIN_BET, '
            , ', @_MAX_BET, '
            , ', @_LIMIT_BUANG, '
            from
            togel_setting_game
            where
            togel_game_id = ', togel_game_id, '
            and constant_provider_togel_id = ', constant_provider_togel_id, ';
            ');

            PREPARE stmt FROM @query;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;

            END;
        ";
        \DB::unprepared($procedure);
        /*4D3D2D*/
        /*SET @__optional='none';
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=1;
        SET @__type='2d_depan';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);*/


        /*Colok bebas*/
        /*SET @__optional='none';
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=5;
        SET @__type='none';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);*/

        /*Colok macau*/
        /*SET @__optional='none';
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=6;
        SET @__type='none';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);*/

        /*Colok naga*/
        /*SET @__optional='none';
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=7;
        SET @__type='none';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);*/

        /*Colok jitu*/
        /*SET @__optional='none';
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=8;
        SET @__type='none';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);*/

        /*5050 umum*/
        /*SET @__optional='kecil'; -- besar, kecil, genap, ganjil, tengah, tepi
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=9;
        SET @__type='none';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);*/

        /*5050 special*/
        /*SET @__optional='as_genap'; -- as_genap, as_ganjil, as_besar, as_kecil(as,kop,kepala,ekor)
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=10;
        SET @__type='none';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);*/

        /*5050 kombinasi*/
        /*SET @__optional='belakang_mono'; -- belakang_mono, tengah_mono, depan_mono(mono,stereo);(kembang,kempis,kembar)
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=11;
        SET @__type='none';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);*/

        /*lainlain kombinasi*/
        /*SET @__optional='none';
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=12;
        SET @__type='none';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);*/

        /*lainlain dasar*/
        /*SET @__optional='besar'; -- (besar,kecil)(genap,ganjil)
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=13;
        SET @__type='none';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);*/

        /*lainlain shio*/
        /*SET @__optional='none';
        SET @__constant_provider_togel_id=1;
        SET @__togel_game_id=14;
        SET @__type='none';
        CALL `get_setting_game_without_win`(@__optional, @__constant_provider_togel_id, @__togel_game_id, @__type);
        select * from togel_game a order by a.id desc;*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP PROCEDURE IF EXISTS `trigger_togeL_blok_angka_after_bets_togel`');
    }
}
