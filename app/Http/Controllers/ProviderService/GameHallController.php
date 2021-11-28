<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;

class GameHallController extends Controller
{
    // Token From Casino Provider 
    protected string $token;

    // this As Object From Token Decoded
    protected object $transaction;

    // Before this Controller is called, we need to check if the user is logged in
    public function __construct()
    {
        $this->token =  request()->token;
        $this->transaction = JWT::decode($this->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
    }

    // Listen Transaction From Decoded Token
    public function listenTransaction()
    {
        $action = $this->transaction->action;

        switch ($action) {
            case 'bet':
                return $this->bet();
                break;

            case 'cancelBet':
                return $this->bet();
                break;

            case 'voidBet':
                return $this->bet();
                break;
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Action not found'
        ]);
    }


    public function Bet()
    {

    }

    public function CancelBet()
    {
    }

    public function VoidBet()
    {
    }

    public function SettleBet()
    {
    }

    public function AdjustBet()
    {
    }

    public function UnVoidBet()
    {
    }

    public function RefunBet()
    {
    }

    public function Settle()
    {
    }

    public function UnSettle()
    {
    }

    public function VoidSettle()
    {
    }

    public function UnVoidSettle()
    {
    }

    public function Give()
    {
    }

    public function Tip()
    {
    }

    public function CancelTip()
    {
    }
}
