<?php

use Illuminate\Database\Seeder;

class ConstantBonusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('constant_bonus')->insert(['id' => '1','nama_bonus' => 'Bonus Turnover','created_by' => '0','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-06 10:40:10','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_bonus')->insert(['id' => '2','nama_bonus' => 'Bonus Cashback','created_by' => '0','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-06 10:40:33','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_bonus')->insert(['id' => '3','nama_bonus' => 'Bonus Referral','created_by' => '0','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-06 10:40:33','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_bonus')->insert(['id' => '4','nama_bonus' => 'Bonus FreeBet','created_by' => '0','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-06 10:40:33','updated_at' => NULL,'deleted_at' => NULL]);
    }
}
