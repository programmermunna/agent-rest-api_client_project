<?php

use Illuminate\Database\Seeder;

class ConstantRekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('constant_rekening')->insert(['id' => '1','name' => 'BCA','is_bank' => '1','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => '1','updated_at' => '2021-09-03 20:33:23','deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '2','name' => 'Mandiri','is_bank' => '1','status' => '2','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => '1','updated_at' => '2021-07-30 20:53:58','deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '3','name' => 'BNI','is_bank' => '1','status' => '3','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => '41','updated_at' => '2021-08-12 12:33:23','deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '4','name' => 'BRI','is_bank' => '1','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => '40','updated_at' => '2021-08-24 02:59:33','deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '5','name' => 'CIMB','is_bank' => '1','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => '40','updated_at' => '2021-07-08 02:39:47','deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '6','name' => 'Danamon','is_bank' => '1','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => '35','updated_at' => '2021-06-12 02:15:00','deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '7','name' => 'Telkomsel','is_bank' => '0','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => NULL,'updated_at' => NULL,'deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '8','name' => 'Axiata','is_bank' => '0','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => '40','updated_at' => '2021-09-02 02:27:42','deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '9','name' => 'OVO','is_bank' => '0','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => NULL,'updated_at' => NULL,'deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '10','name' => 'GOPAY','is_bank' => '0','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => NULL,'updated_at' => NULL,'deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '11','name' => 'DANA','is_bank' => '0','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => NULL,'updated_at' => NULL,'deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '12','name' => 'LinkAja','is_bank' => '0','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2020-10-27 16:04:45','updated_by' => NULL,'updated_at' => NULL,'deleted_by' => NULL,'deleted_at' => NULL]);
        \DB::table('constant_rekening')->insert(['id' => '13','name' => 'TesBank','is_bank' => '1','status' => '1','logo' => NULL,'created_by' => '40','created_at' => '2021-09-01 00:19:01','updated_by' => NULL,'updated_at' => '2021-09-01 00:20:35','deleted_by' => '40','deleted_at' => '2021-09-01 00:20:35']);
        \DB::table('constant_rekening')->insert(['id' => '14','name' => 'XL EDIT','is_bank' => '0','status' => '1','logo' => NULL,'created_by' => '1','created_at' => '2021-09-01 04:07:21','updated_by' => '1','updated_at' => '2021-09-01 04:07:41','deleted_by' => '1','deleted_at' => '2021-09-01 04:07:41']);
    }
}
