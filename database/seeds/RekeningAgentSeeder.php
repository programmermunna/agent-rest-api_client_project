<?php

use Illuminate\Database\Seeder;

class RekeningAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('rekening')->insert([
            'constant_rekening_id' => 1,
            'nomor_rekening' => 111111,
            'nama_rekening' => 'AgentBca',
            'is_bank' => 1,
            'is_default' => 0,
            'is_depo' => 1,
            'is_wd' => 0,
        ]);
        \DB::table('rekening')->insert([
            'constant_rekening_id' => 2,
            'nomor_rekening' => 222222,
            'nama_rekening' => 'AgentMandiri',
            'is_bank' => 1,
            'is_default' => 0,
            'is_depo' => 0,
            'is_wd' => 1,
        ]);
        \DB::table('rekening')->insert([
            'constant_rekening_id' => 3,
            'nomor_rekening' => 333333,
            'nama_rekening' => 'AgentBni',
            'is_bank' => 1,
            'is_default' => 1,
            'is_depo' => 0,
            'is_wd' => 1,
        ]);
        \DB::table('rekening')->insert([
            'constant_rekening_id' => 4,
            'nomor_rekening' => 4444444,
            'nama_rekening' => 'AgentBri',
            'is_bank' => 1,
            'is_default' => 1,
            'is_depo' => 1,
            'is_wd' => 0,
        ]);
        \DB::table('rekening')->insert([
            'constant_rekening_id' => 5,
            'nomor_rekening' => 555555,
            'nama_rekening' => 'AgentCimb',
            'is_bank' => 1,
            'is_default' => 1,
            'is_depo' => 0,
            'is_wd' => 1,
        ]);
        \DB::table('rekening')->insert([
            'constant_rekening_id' => 6,
            'nomor_rekening' => 666666,
            'nama_rekening' => 'AgentDanamon',
            'is_bank' => 1,
            'is_default' => 1,
            'is_depo' => 1,
            'is_wd' => 0,
        ]);
    }
}
