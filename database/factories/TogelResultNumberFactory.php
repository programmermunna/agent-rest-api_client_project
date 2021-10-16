<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TogelResultNumberModel;
use Faker\Generator as Faker;

/**
 * @author Hanan Asyrawi
 */
$factory->define(TogelResultNumberModel::class, function (Faker $faker) {

    return [
		'constant_provider_togel_id' => $faker->randomElement([1,2,3,4,5,6]),
		'result_date'     => now()->addDays(random_int(1 , 7))->format('y-m-d'),
		'number_result_1' => $faker->randomDigit(9),
		'number_result_2' => $faker->randomDigit(9),
		'number_result_3' => $faker->randomDigit(9),
		'number_result_4' => $faker->randomDigit(9),
		'number_result_5' => $faker->randomDigit(9),
		'number_result_6' => $faker->randomDigit(9),
		'period' 		 => $faker->randomDigit(200),
		'created_by'      => 1
    ];
});
