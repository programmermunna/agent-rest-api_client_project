<?php

use Illuminate\Database\Seeder;

class TogelDiscountKeiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('togel_discount_kei')->insert([
            'id' => 1,
            'currency_percentage_symbol' => '%', 
            'discount_kei' => '-', 
            'nominal' => 66, 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);

        \DB::table('togel_discount_kei')->insert([
            'id' => 2,
            'currency_percentage_symbol' => '%', 
            'discount_kei' => '-', 
            'nominal' => 5, 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);

        \DB::table('togel_discount_kei')->insert([
            'id' => 3,
            'currency_percentage_symbol' => '%', 
            'discount_kei' => '+', 
            'nominal' => 1.5, 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);

        \DB::table('togel_discount_kei')->insert([
            'id' => 4,
            'currency_percentage_symbol' => '%', 
            'discount_kei' => '+', 
            'nominal' => 2, 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);

        \DB::table('togel_discount_kei')->insert([
            'id' => 5,
            'currency_percentage_symbol' => '%', 
            'discount_kei' => '+', 
            'nominal' => 25, 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);

        \DB::table('togel_discount_kei')->insert([
            'id' => 6,
            'currency_percentage_symbol' => '%', 
            'discount_kei' => '-', 
            'nominal' => 29, 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);

        \DB::table('togel_discount_kei')->insert([
            'id' => 7,
            'currency_percentage_symbol' => '%', 
            'discount_kei' => '-', 
            'nominal' => 0, 
            'created_by' => 2, 
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")
        ]);
    }
}
