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
        DB::table('constant_provider')->insert([
        	'constant_provider_name' => 'Pragmatic',
        ]);
        DB::table('constant_provider')->insert([
        	'constant_provider_name' => 'Habanero',
        ]);
        DB::table('constant_provider')->insert([
        	'constant_provider_name' => 'Joker Gaming',
        ]);
        DB::table('constant_provider')->insert([
        	'constant_provider_name' => 'Spade Gaming',
        ]);
        DB::table('constant_provider')->insert([
        	'constant_provider_name' => 'Pg Soft',
        ]);
        DB::table('constant_provider')->insert([
        	'constant_provider_name' => 'Playtech',
        ]);
    }
}
