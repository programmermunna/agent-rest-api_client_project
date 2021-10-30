<?php

use Illuminate\Database\Seeder;

class ConstantProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('constant_provider')->insert(['id' => '1','api_key' => 'GZMzyuYaNMuy3s9B','brand_id' => 'sbbtap_cikatech','constant_provider_name' => 'Pragmatic','created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_provider')->insert(['id' => '2','api_key' => '5C8E396F-68BD-4CAA-8DA2-CE2A88BBB9D5','brand_id' => '8a68a05a-9204-ec11-b563-00155db8a3c7','constant_provider_name' => 'Habanero','created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_provider')->insert(['id' => '3','api_key' => 's5g5tk5yt8x4o','brand_id' => 'F7C5','constant_provider_name' => 'Joker Gaming','created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_provider')->insert(['id' => '4','api_key' => '','brand_id' => 'A88','constant_provider_name' => 'Spade Gaming','created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_provider')->insert(['id' => '5','api_key' => '','brand_id' => '','constant_provider_name' => 'Pg Soft','created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_provider')->insert(['id' => '6','api_key' => '','brand_id' => '','constant_provider_name' => 'Playtech','created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL]);
    }
}
