<?php

use App\Models\TogelResultNumberModel;
use Illuminate\Database\Seeder;

class TogelResultNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TogelResultNumberModel::class , 200)->create(); 
    }
}
