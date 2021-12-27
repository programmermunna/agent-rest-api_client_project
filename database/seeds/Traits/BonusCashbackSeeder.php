<?php

use Illuminate\Database\Seeder;

class BonusCashbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('bonus_cashback')->insert(['id' => '1','judul' => 'Cashback','value' => '5','min_lose' => '50,000','max_lose' => '1,000,000','created_by' => '40','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-09-04 03:52:27','updated_at' => '2021-09-09 00:40:09','deleted_at' => NULL]);
        \DB::table('bonus_cashback')->insert(['id' => '2','judul' => 'Cashback','value' => '7','min_lose' => '1,001,000','max_lose' => '10,000,000','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:52:52','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_cashback')->insert(['id' => '3','judul' => 'Cashback','value' => '10','min_lose' => '10,100,000','max_lose' => '1,000,000,000,000','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:53:16','updated_at' => NULL,'deleted_at' => NULL]);
    }
}
