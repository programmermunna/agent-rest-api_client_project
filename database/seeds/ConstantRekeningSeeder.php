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
        \DB::table('constant_rekening')->insert([
            'name' => 'BCA',
            'is_bank' => 1,
            'status' => 1,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'Mandiri',
            'is_bank' => 1,
            'status' => 2,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'BNI',
            'is_bank' => 1,
            'status' => 3,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'BRI',
            'is_bank' => 1,
            'status' => 3,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'CIMB',
            'is_bank' => 1,
            'status' => 1,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'Danamon',
            'is_bank' => 1,
            'status' => 1,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'Telkomsel',
            'is_bank' => 0,
            'status' => 1,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'Axiata',
            'is_bank' => 0,
            'status' => 1,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'OVO',
            'is_bank' => 0,
            'status' => 1,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'GOPAY',
            'is_bank' => 0,
            'status' => 1,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'DANA',
            'is_bank' => 0,
            'status' => 1,
        ]);
        \DB::table('constant_rekening')->insert([
            'name' => 'LinkAja',
            'is_bank' => 0,
            'status' => 1,
        ]);
    }
}
