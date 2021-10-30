<?php

use Illuminate\Database\Seeder;

class TogelCategoryGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('togel_category_game')->insert([
            'id' => 1,
            'name' => '4D/3D/2D', 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);

        \DB::table('togel_category_game')->insert([
            'id' => 2,
            'name' => 'Colok', 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);

        \DB::table('togel_category_game')->insert([
            'id' => 3,
            'name' => '50-50', 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);

        \DB::table('togel_category_game')->insert([
            'id' => 4,
            'name' => 'Lain-lain', 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);
    }
}
