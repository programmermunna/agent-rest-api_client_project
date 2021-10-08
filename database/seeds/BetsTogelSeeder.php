<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BetsTogelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        for ($i=0; $i < 100 ; $i++) { 
            DB::table('bets_togel')->insert(
                [
                'togel_game_id' => '1',
                'constant_provider_togel_id' => '1',
                'togel_setting_game_id' => '1', 
                'period' => '099',
                'number_1' => null,
                'number_2' => null,
                'number_3' => '8',
                'number_4' => '6',
                'number_5' => '1',
                'number_6' => '5',
                'tebak_as_kop_kepala_ekor' => null,
                'tebak_besar_kecil' => null,
                'tebak_genap_ganjil' => null,
                'tebak_tengah_tepi' => null,
                'tebak_depan_tengah_belakang' => null,
                'tebak_mono_stereo' => null,
                'tebak_kembang_kempis_kembar' => null,
                'tebak_shio' => null,
                'win_lose_status' => '0',
                'togel_results_number_id' => null,
                'win_nominal' => null,
                'bet_amount' => '100.00',
                'tax_amount' => '66.00',
                'pay_amount' => '34.00',
                'created_by' => '3',
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => '2021-10-05 07:28:59',
                'updated_at' => null,
                'deleted_at' => null
                ]
            );
        }

    }    
}
