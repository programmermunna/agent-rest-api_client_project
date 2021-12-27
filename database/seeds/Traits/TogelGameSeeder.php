<?php

use Illuminate\Database\Seeder;

class TogelGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('togel_game')->insert([
            'id' => '1',
            'name' => '4D/3D/2D',
            'togel_category_game_id' => '1',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '2',
            'name' => '4D/3D/2D Set',
            'togel_category_game_id' => '1',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '3',
            'name' => 'Bolak Balik',
            'togel_category_game_id' => '1',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '4',
            'name' => 'Quick 2D',
            'togel_category_game_id' => '1',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '5',
            'name' => 'Colok Bebas',
            'togel_category_game_id' => '2',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '6',
            'name' => 'Colok Macau',
            'togel_category_game_id' => '2',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '7',
            'name' => 'Colok Naga',
            'togel_category_game_id' => '2',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '8',
            'name' => 'Colok Jitu',
            'togel_category_game_id' => '2',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '9',
            'name' => '50-50 Umum',
            'togel_category_game_id' => '3',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '10',
            'name' => '50-50 Special',
            'togel_category_game_id' => '3',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '11',
            'name' => '50-50 Kombinasi',
            'togel_category_game_id' => '3',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '12',
            'name' => 'Macau/Kombinasi',
            'togel_category_game_id' => '4',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '13',
            'name' => 'Dasar',
            'togel_category_game_id' => '4',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('togel_game')->insert([
            'id' => '14',
            'name' => 'Shio',
            'togel_category_game_id' => '4',
            'created_by' => '1',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
    }
}
