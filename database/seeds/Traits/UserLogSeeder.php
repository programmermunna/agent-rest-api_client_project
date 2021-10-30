<?php

use Illuminate\Database\Seeder;

class UserLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('activity_log')->insert(['id' => '11326','log_name' => 'Member Login','description' => 'Successfully','subject_id' => '36','subject_type' => 'App\\Models\\MembersModel','causer_id' => '36','causer_type' => 'App\\Models\\MembersModel','properties' => '{"ip": "3.0.47.49", "device": "(Mobile) Brand name: Samsung. Model: phone", "target": "kartikasari", "activity": "Logged In"}','created_at' => '2021-09-19 05:56:05','updated_at' => '2021-09-19 05:56:05','deleted_at' => NULL]);
    }
}
