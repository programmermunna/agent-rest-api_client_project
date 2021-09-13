<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

trait ApiResponser
{
    protected function successResponse($data, $message = null, $code = 200, $additionalArray = [])
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'additional' => $additionalArray,
        ], $code);
    }

    protected function errorResponse($message = null, $code, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function pagination($items, $page = null, $perPage = 15, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    //"WE DON'T NEED THIS FAKER FOR PRODUCTION", DON'T ENABLE THIS
//
//    protected function fake($type)
//    {
//        $faker = Factory::create();
//        $date = Carbon::now();
//
//        if ($type == 'memo') {
//            $fakeData = [];
//            $is_read = false;
//
//            for ($i = 0; $i < 50; $i++) {
//                if ($i == 10) {
//                    $is_read = true;
//                }
//                $fakeData[] = [
//                    'id' => $faker->uuid(),
//                    'subject' => $faker->realText($faker->numberBetween(10, 20)),
//                    'content' => $faker->text(400),
//                    'received_at' => $date->subDays($i)->format('Y-m-d\TH:i:s.uP'),
//                    'is_read' => $is_read,
//                ];
//            }
//        }
//
//        if ($type == 'statement') {
//            $fakeData = [];
//
//            for ($i = 0; $i < 50; $i++) {
//                $fakeData[] = [
//                    'id' => $i+1,
//                    'description' => $faker->realText($faker->numberBetween(10, 20)),
//                    'withdraw' => $faker->randomElement(['Win', 'Lose']),
//                    'deposit' => $faker->randomElement(['Bet/Lose', 'Bet/Win']),
//                    'date' => $date->subDays($i)->format('Y-m-d\TH:i:s.uP'),
//                ];
//            }
//        }
//
//        if ($type == 'referral') {
//            $fakeData = [];
//
//            for ($i = 0; $i < 50; $i++) {
//                $fakeData[] = [
//                    'id' => $i + 1,
//                    'user_referral' => $faker->name,
//                    'last_activity' => $faker->randomElement(['Slot', 'Toggle', 'Live game', 'Sport']),
//                    'bonus_activity' => (0.1 / 100) * $faker->randomElement(['5000', '10000', '20000', '30000', '500000', '100000']),
//                ];
//            }
//        }
//
//
//        return $fakeData;
//    }
}
