
<?php

use Illuminate\Database\Seeder;

class BetsTogelHistoryTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*only used if the data does not exist*/

        // \DB::table('bets_togel')->insert([
        //     'id' => '1',
        //     'togel_game_id' => '1',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '099',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => '8',
        //     'number_4' => '6',
        //     'number_5' => '1',
        //     'number_6' => '5',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '100.00',
        //     'togel_setting_game_id' => '1',
        //     'tax_amount' => '66.00',
        //     'pay_amount' => '34.00',
        //     'created_by' => '3',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => '2021-10-05 07:28:59',
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '2',
        //     'togel_game_id' => '1',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '099',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => '7',
        //     'number_5' => '2',
        //     'number_6' => '6',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '1',
        //     'togel_results_number_id' => '1',
        //     'win_nominal' => '500000.00',
        //     'bet_amount' => '100.00',
        //     'togel_setting_game_id' => '1',
        //     'tax_amount' => '66.00',
        //     'pay_amount' => '34.00',
        //     'created_by' => '3',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => '2021-10-05 07:28:59',
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '3',
        //     'togel_game_id' => '1',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '099',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => '8',
        //     'number_5' => '3',
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '100.00',
        //     'togel_setting_game_id' => '1',
        //     'tax_amount' => '66.00',
        //     'pay_amount' => '34.00',
        //     'created_by' => '3',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => '2021-10-05 07:28:59',
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '4',
        //     'togel_game_id' => '1',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '099',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => '9',
        //     'number_4' => '7',
        //     'number_5' => '2',
        //     'number_6' => '0',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '100.00',
        //     'togel_setting_game_id' => '1',
        //     'tax_amount' => '66.00',
        //     'pay_amount' => '34.00',
        //     'created_by' => '3',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => '2021-10-05 07:28:59',
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '50',
        //     'togel_game_id' => '1',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '099',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => '9',
        //     'number_4' => '7',
        //     'number_5' => '2',
        //     'number_6' => '0',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '100.00',
        //     'togel_setting_game_id' => '1',
        //     'tax_amount' => '66.00',
        //     'pay_amount' => '34.00',
        //     'created_by' => '3',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => '2021-10-05 07:28:59',
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);

        /*--only used if the data does not exist*/


        \DB::select(\DB::raw("
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
            /*History transaksi*/
            select
            SUBSTRING_INDEX(group_concat(a.id), ',', 1) as 'Bet ID'
            , concat(b.name_initial, '-' , b.period) as 'Pasaran'
            , SUBSTRING_INDEX(group_concat(a.id), ',', 1) as 'Bet ID'
            , concat('Bet:4D/3D/2D (Mixed ', group_concat(if (
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
            , 'nulled'
            )
            )
            )
            )
            )), ')') as 'Deskripsi'
            , sum(if (
            if(
            a.win_nominal is null
            , 0
            , a.win_nominal
            ) -
            if(
            a.pay_amount is null
            , 0
            , a.pay_amount
            )
            < 0
            , a.pay_amount
            , 0
            )) as 'Debit'
            , sum(if (
            if(
            a.win_nominal is null
            , 0
            , a.win_nominal
            ) -
            if(
            a.pay_amount is null
            , 0
            , a.pay_amount
            )
            < 0
            , 0
            , a.win_nominal
            )) as 'Kredit'
            , sum(c.credit) as 'Balance'
            , a.created_by as 'createdBy'
            , a.created_at as 'createdAt'
            from
            bets_togel a
            join constant_provider_togel b on a.constant_provider_togel_id = b.id
            join members c on a.created_by = c.id
            where a.togel_game_id = 1 -- sample data, adapted to the query select
            group by a.created_at, a.constant_provider_togel_id, a.created_by, a.period;
          "));
    }
}
