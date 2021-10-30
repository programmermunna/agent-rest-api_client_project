<?php

use Illuminate\Database\Seeder;

class BonusTurnoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('bonus_turnover')->insert(['id' => '1','judul' => 'Pencapaian Turnover','value' => '50,000,000','type' => 'uang','hadiah' => '50,000','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:53:49','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '2','judul' => 'Pencapaian Turnover','value' => '100,000,000','type' => 'uang','hadiah' => '100,000','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:54:03','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '3','judul' => 'Pencapaian Turnover','value' => '200,000,000','type' => 'uang','hadiah' => '200,000','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:54:16','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '4','judul' => 'Pencapaian Turnover','value' => '300,000,000','type' => 'uang','hadiah' => '300,000','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:54:34','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '5','judul' => 'Pencapaian Turnover','value' => '500,000,000','type' => 'uang','hadiah' => '600,000','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:54:50','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '6','judul' => 'Pencapaian Turnover','value' => '1,000,000,000','type' => 'uang','hadiah' => '1,500,000','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:55:13','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '7','judul' => 'Pencapaian Turnover','value' => '2,000,000,000','type' => 'uang','hadiah' => '3,000,000','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:55:40','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '8','judul' => 'Pencapaian Turnover','value' => '5,000,000,000','type' => 'barang','hadiah' => 'Hp Samsung S21+ Ultra 128gb','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:56:10','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '9','judul' => 'Pencapaian Turnover','value' => '10,000,000,000','type' => 'barang','hadiah' => 'Hp Iphone 12 Pro Max 256GB','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:56:39','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '10','judul' => 'Pencapaian Turnover','value' => '25,000,000,000','type' => 'barang','hadiah' => 'Yamaha XMAX 250','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:56:59','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '11','judul' => 'Pencapaian Turnover','value' => '50,000,000,000','type' => 'barang','hadiah' => 'Kawasaki Z126 PRO 2021','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:57:23','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '12','judul' => 'Pencapaian Turnover','value' => '100,000,000,000','type' => 'barang','hadiah' => 'Honda Accord 2021','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:57:42','updated_at' => NULL,'deleted_at' => NULL]);
        \DB::table('bonus_turnover')->insert(['id' => '13','judul' => 'Pencapaian Turnover','value' => '1,000,000,000,000','type' => 'barang','hadiah' => 'Mercedes Benz GL-400','created_by' => '40','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-04 03:58:04','updated_at' => NULL,'deleted_at' => NULL]);
    }
}
