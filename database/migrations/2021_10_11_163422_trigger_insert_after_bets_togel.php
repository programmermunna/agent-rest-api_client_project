<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerInsertAfterBetsTogel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "DROP PROCEDURE IF EXISTS `TriggerInsertAfterBetsTogel`;            
            CREATE PROCEDURE TriggerInsertAfterBetsTogel(IN bets_togel_ids VARCHAR(255))
            BEGIN
                SET @query = CONCAT ('
                /*insert event ke tabel bets_togel_history_transaksi*/
                insert into bets_togel_history_transaksi (
                                                        bets_togel_id
                                                        , pasaran
                                                        , bet_id
                                                        , description
                                                        , debit
                                                        , kredit
                                                        , balance
                                                        , created_by
                                                        , created_at)
                /*4D/3D/2D*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:4D/3D/2D (Mixed '', group_concat(if (
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
                                    , ''nulled''
                                )
                            )
                        )
                    )
                )), '')'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                where a.togel_game_id = 1
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
            
                union
            
                /*colok bebas*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:Colok bebas (Mixed '', group_concat(a.number_6), '')'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                where a.togel_game_id = 5
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
            
                union
            
                /*colok macau*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:Colok macau (Mixed '', group_concat(a.number_5, a.number_6), '')'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                where a.togel_game_id = 6
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
            
                union
            
                /*colok naga*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:Colok naga (Mixed '', group_concat(a.number_4, a.number_5, a.number_6), '')'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                where a.togel_game_id = 7
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
            
                union
            
            
                /*colok jitu*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:Colok jitu (Mixed '', group_concat(a.number_6, '' '', a.tebak_as_kop_kepala_ekor), '')'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                where a.togel_game_id = 8
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
            
                union
            
                /*5050 umum*/
                /*Genap ganjil*/
                /*Besar kecil*/
                /*Tengah tepi*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:50-50 Umum'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                where a.togel_game_id = 9
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
            
            
                union
            
                /*5050 special*/
                /*askopkepalaekor ganjilgenap*/
                /*askopkepalaekor besarkecil*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:50-50 Special'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                where a.togel_game_id = 10
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
            
                union
            
                /*5050 kombinasi*/
                /*depantengahbelakang monostereo*/
                /*depantengahbelakang kembangkempiskembar*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:50-50 kombinasi'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                where a.togel_game_id = 11
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
            
                union
            
                /*lainlain kombinasi*/
                /*depantengahbelakang besarkecil genapganjil*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:lain-lain kombinasi (Mixed '', group_concat(
                    if (
                        a.tebak_depan_tengah_belakang is not null and a.tebak_besar_kecil is not null and a.tebak_genap_ganjil
                        , concat(a.tebak_depan_tengah_belakang, '' '', a.tebak_besar_kecil, '' '', a.tebak_genap_ganjil)
                        , ''nulled''
                    )
                ), '')'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                where a.togel_game_id = 12
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
            
            
                union
            
                /*lainlain dasar*/
                /*ganjilgenap*/
                /*besarkecil*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:lain-lain kombinasi (Mixed '', group_concat(
                    if (
                        a.tebak_genap_ganjil is not null
                        , a.tebak_genap_ganjil
                        , if (
                            a.tebak_besar_kecil is not null
                            , a.tebak_besar_kecil
                            , ''nulled''
                        )
                    )
                ), '')'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                where a.togel_game_id = 13
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
            
                union
            
                /*lainlain shio*/
                select
                SUBSTRING_INDEX(group_concat(a.id), '','', 1)
                , concat(b.name_initial, ''-'' , b.period) as ''Pasaran''
                , GROUP_CONCAT(DISTINCT a.id ORDER BY a.id DESC SEPARATOR '','') as ''Bet ID''
                , concat(''Bet:lain-lain kombinasi (Mixed '', group_concat(
                    if (
                        a.tebak_shio is not null
                        , d.name
                        , ''nulled''
                    )
                ), '')'') as ''Deskripsi''
                , sum(
                    if(
                        a.pay_amount is null
                        , 0
                        , a.pay_amount
                    )
                ) as ''Debit''
                , 0 as ''Kredit''
                , sum(c.credit) as ''Balance''
                , a.created_by as ''createdBy''
                , a.created_at as ''createdAt''
                from
                bets_togel a
                join constant_provider_togel b on a.constant_provider_togel_id = b.id
                join members c on a.created_by = c.id
                join togel_shio_name d on a.tebak_shio = d.id
                where a.togel_game_id = 14
                and a.id in (',bets_togel_ids,')
                group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period
                ;');
            
                PREPARE stmt FROM @query;
                EXECUTE stmt;
                DEALLOCATE PREPARE stmt;
            END;
        ";

        \DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        \DB::unprepared('DROP PROCEDURE IF EXISTS `TriggerInsertAfterBetsTogel`');
    }
}
