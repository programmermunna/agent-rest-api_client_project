<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerIsBuanganBeforeTerpasangAfterBetsTogel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
        DROP PROCEDURE IF EXISTS `is_buangan_before_terpasang` ;
        CREATE procedure `is_buangan_before_terpasang`(IN `bet_ids` text)
        /*UNTUK KEPERLUAN API BETS TOGEL*/
        BEGIN
            /*select @cout := 0;*/
            SET @query = CONCAT ('
                select
                count(*) into @cout
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join constant_provider_togel_wl c on b.name = c.name and b.name_initial = c.name_initial
                where
                /*bets_togel_id*/', bet_ids);
            PREPARE stmt FROM @query;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;

            if @cout > 0 then
            BEGIN
                DROP TEMPORARY TABLE IF EXISTS is_buangan;
                CREATE TEMPORARY TABLE is_buangan(
                    bet_id bigint(20)
                    , constant_provider_togel_id bigint(20)
                    , is_bets_buangan tinyint(2)
                    , buangan_before_submit decimal(13,2)
                );
                SET @query = CONCAT ('                    
                    insert into is_buangan (bet_id, constant_provider_togel_id, is_bets_buangan, buangan_before_submit)
                    select
                    a.id as bet_id
                    , a.constant_provider_togel_id
                    , 1 as ''is_bets_buangan''
                    , if (
                        a.number_6 is not null and a.number_5 is not null and a.number_4 is not null and a.number_3 is not null and a.number_2 is null and a.number_1 is null
                        , if ((a.bet_amount - b.limit_buang_4d) > 0, (a.bet_amount - b.limit_buang_4d), 0)
                        , if (
                            a.number_6 is not null and a.number_5 is not null and a.number_4 is not null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                            , if ((a.bet_amount - b.limit_buang_3d) > 0, (a.bet_amount - b.limit_buang_3d), 0)
                            , if (
                                a.number_6 is not null and a.number_5 is not null and a.number_4 is null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                                , if ((a.bet_amount - b.limit_buang_2d) > 0, (a.bet_amount - b.limit_buang_2d), 0)
                                , if (
                                    a.number_6 is null and a.number_5 is not null and a.number_4 is not null and a.number_3 is null and a.number_2 is null and a.number_1 is null
                                    , if ((a.bet_amount - b.limit_buang_2d_tengah) > 0, (a.bet_amount - b.limit_buang_2d_tengah), 0)
                                    , if (
                                        a.number_6 is null and a.number_5 is null and a.number_4 is not null and a.number_3 is not null and a.number_2 is null and a.number_1 is null
                                        , if ((a.bet_amount - b.limit_buang_2d_depan) > 0, (a.bet_amount - b.limit_buang_2d_depan), 0)
                                        , if ((a.bet_amount - b.limit_buang) > 0, (a.bet_amount - b.limit_buang), 0)
                                    )
                                )
                            )
                        )
                    ) as ''buangan_before_submit''
                    from
                    bets_togel a
                    join togel_setting_game b on a.togel_setting_game_id = b.id
                    join togel_game c on a.togel_game_id = c.id
                    join constant_provider_togel d on a.constant_provider_togel_id = d.id
                    join constant_provider_togel_wl e on d.name = e.name and d.name_initial = e.name_initial
                    where ',bet_ids , ' ;
                    ');

                PREPARE stmt FROM @query;
                EXECUTE stmt;
                DEALLOCATE PREPARE stmt;
                
                select
                    JSON_ARRAYAGG(JSON_OBJECT(
                        'bet_id', a.bet_id
                        , 'constant_provider_togel_id', a.constant_provider_togel_id
                        , 'is_bets_buangan', a.is_bets_buangan
                        , 'buangan_before_submit', a.buangan_before_submit
                    )) as results
                from
                is_buangan a
                where
                a.buangan_before_submit > 0;

                DROP TEMPORARY TABLE IF EXISTS is_buangan;
                
                /*select
                    @buangan_before_submit as 'buangan_before_submit'
                    , 1 as 'is_bets_buangan';*/
            END;
            END IF;
        END;
        ";
        /*SET @bet_ids=' a.id in (1,2,3,4)';
        CALL `is_buangan_before_terpasang`(@bet_ids);*/

        \DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP PROCEDURE IF EXISTS `is_buangan_before_terpasang`');
    }
}
