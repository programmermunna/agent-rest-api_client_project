<?php

namespace Tests\Feature\Api;

use App\Models\MembersModel;
use Tests\TestCase;

class GameHallTest extends TestCase
{

    public function test_bet()
    {

        $balance = MembersModel::query()->find('220')->credit;
        ray($balance);
        $this->postJson('/api/endpoint/bet_gameHall', [
            "token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY3Rpb24iOiJiZXQiLCJ0eG5zIjpbeyJwbGF0Zm9ybVR4SWQiOiJUU1QtMjEwMDAwOTkzNDAiLCJ1c2VySWQiOiIyMjAiLCJwbGF0Zm9ybSI6IlNFWFlCQ1JUIiwiZ2FtZVR5cGUiOiJMSVZFIiwiZ2FtZUNvZGUiOiJNWC1MSVZFLTAwMSIsImdhbWVOYW1lIjoiQmFjY2FyYXRDbGFzc2ljIiwiYmV0VHlwZSI6IkJhbmtlciIsImJldEFtb3VudCI6NTAwMCwid2luQW1vdW50Ijo5NzUwLCJ0dXJub3ZlciI6NDc1MCwicmVmUGxhdGZvcm1UeElkIjpudWxsLCJzZXR0bGVUeXBlIjoicGxhdGZvcm1UeElkIiwiYmV0VGltZSI6IjIwMjEtMTItMDFUMDY6MTE6MjMuNTYwKzA4OjAwIiwidHhUaW1lIjoiMjAyMS0xMi0wMVQwNjoxMToyMy41NjArMDg6MDAiLCJ1cGRhdGVUaW1lIjoiMjAyMS0xMi0wMVQwNjoxMTozMC45MTIrMDg6MDAiLCJyb3VuZElkIjoiRHVtbXktMDEtR0EzMTAwMDEwODcwIn1dLCJpYXQiOjE2MzgzNzY4Mzl9._lKki0Fvrd5eSLLMcHybGs3CIrjBSEEPThHHQjJ3tEM",
        ])->assertJson([
            'status' => '0000',
        ]);
        $balance1 = MembersModel::query()->find('220')->credit;
        ray($balance1);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_settle_request_five_times()
    {
        $balance = MembersModel::query()->find('220')->credit;
        $count = 0;
        ray($balance);
        while ($count <= 5) {
            # code...
            $this->postJson('/api/endpoint/bet_gameHall', [
                "token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY3Rpb24iOiJzZXR0bGUiLCJ0eG5zIjpbeyJwbGF0Zm9ybVR4SWQiOiJUU1QtMjEwMDAwOTkzNDAiLCJ1c2VySWQiOiIyMjAiLCJwbGF0Zm9ybSI6IlNFWFlCQ1JUIiwiZ2FtZVR5cGUiOiJMSVZFIiwiZ2FtZUNvZGUiOiJNWC1MSVZFLTAwMSIsImdhbWVOYW1lIjoiQmFjY2FyYXRDbGFzc2ljIiwiYmV0VHlwZSI6IkJhbmtlciIsImJldEFtb3VudCI6NTAwMCwid2luQW1vdW50Ijo5NzUwLCJ0dXJub3ZlciI6NDc1MCwicmVmUGxhdGZvcm1UeElkIjpudWxsLCJzZXR0bGVUeXBlIjoicGxhdGZvcm1UeElkIiwiYmV0VGltZSI6IjIwMjEtMTItMDFUMDY6MTE6MjMuNTYwKzA4OjAwIiwidHhUaW1lIjoiMjAyMS0xMi0wMVQwNjoxMToyMy41NjArMDg6MDAiLCJ1cGRhdGVUaW1lIjoiMjAyMS0xMi0wMVQwNjoxMTozMC45MTIrMDg6MDAiLCJyb3VuZElkIjoiRHVtbXktMDEtR0EzMTAwMDEwODcwIn1dLCJpYXQiOjE2MzgzNzY1NDF9.Jlocla5xzwVXO0cL6vS3W92D3KYnOwB33NC_5U6H-dk",
            ])->assertJson([
                'status' => '0000',
                'balance' => $balance,
            ]);
            $count++;
        }
        $balance1 = MembersModel::query()->find('220')->credit;
        ray($balance1);
    }

    public function test_required_token()
    {
        $response = $this->postJson('/api/endpoint/bet_gameHall');
        $response->assertStatus(500);
    }
}
