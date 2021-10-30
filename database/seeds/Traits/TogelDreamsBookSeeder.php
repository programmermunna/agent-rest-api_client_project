<?php

use Illuminate\Database\Seeder;
use App\Models\TogelDreamsBookModel;

class TogelDreamsBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TogelDreamsBookModel::truncate();
        $csvFile = fopen(base_path("database/data/togel_dreams_book.csv"), "r");

        $line = true;
        while (($data = fgetcsv($csvFile, 1595, ",")) !== false) {
          if (!$line) {
            TogelDreamsBookModel::create([
              'id' => $data[0],
              'name' => $data[1],
              'type' => $data[2],
              'combination_number' => $data[3],
              'created_by' => $data[4],
              'updated_by' => $data[5],
              'deleted_by' => $data[6],
              'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
              'updated_at' => null,
              'deleted_at' => null
            ]);
          }

          $line = false;
        }

        fclose($csvFile);
    }
}
