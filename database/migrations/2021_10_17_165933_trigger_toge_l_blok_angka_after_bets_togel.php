<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerTogeLBlokAngkaAfterBetsTogel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
        DROP PROCEDURE IF EXISTS `trigger_togeL_blok_angka_after_bets_togel`;
        CREATE PROCEDURE `trigger_togeL_blok_angka_after_bets_togel`(IN `conditions` TEXT)
        /*UNTUK KEPERLUAN API BETS TOGEL*/
        BEGIN
        SET @query = CONCAT ('
            select
                JSON_ARRAYAGG(JSON_OBJECT( ''number_3'', ifnull(number_3, null) , ''number_4'', ifnull(number_4, null) , ''number_5'', ifnull(number_5, null) , ''number_6'', ifnull(number_6, null) )) as nomor
            from
            togel_blok_angka where ', conditions);
        PREPARE stmt FROM @query;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
        END;
        ";
        /*set @conditions = 'number_3 is null and number_4 = 6 and number_5 = 6 and number_6 = 4 and constant_provider_togel_id = 1';
        CALL `trigger_togeL_blok_angka_after_bets_togel`(@conditions);*/
        \DB::unprepared($procedure);
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
