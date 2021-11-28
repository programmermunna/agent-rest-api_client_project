<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use App\Models\MembersModel;
use App\Models\BetModel;
use App\Models\UserLogModel;

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
                return [
                    "status" => '0000',
                    "balance" => 100000,
                    "balanceTs" => "2020-12-03T07:14:44.767Z"   
                ];
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
        // call betInformation
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $member =  MembersModel::where('id', $tokenRaw->userId)->first();
            $amountbet = $tokenRaw->betAmount;
            $creditMember = $member->credit;
            $amount = $creditMember - $amountbet;
            if ($amount < 0) {
                return response()->json([
                    'success' => false,
                    'message' =>  $token->creditMember
                ]);
            } else {
                // check if bet already exist
                $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
                if ($bets) {
                    return [
                        "id" => $bets->id,
                        "success" => true,
                        "amout"   => $creditMember,
                        "message"   => 'Bet already exist'
                    ];
                } else {
                    // update credit to table member
                    $member->update([
                        'credit' => $amount,
                        'updated_at' => $tokenRaw->betTime,
                    ]);
    
                    $bets = BetModel::create([
                        'updated_by' => $tokenRaw->userId,
                        'bet_id' => $tokenRaw->platformTxId,
                        'game_info' => 'live_casino',
                        'game_id' => $tokenRaw->gameCode,
                        'round_id' => $tokenRaw->roundId,
                        'type' => 'Bet',
                        'game' => $tokenRaw->gameName,
                        'bet' => $amountbet,
                        'game_info' => $tokenRaw->gameType,
                        'created_at' => $tokenRaw->betTime,
                        'constant_provider_id' => 7,
                        'deskripsi' => 'Game Bet/Lose' . ' : ' . $amountbet,
                    ]);

                    $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
                        ->leftJoin('members', 'members.id', '=', 'bets.created_by')
                        ->where('bets.id', $bets->id)->first();
                    $member =  MembersModel::where('id', $bets->created_by)->first();
                    UserLogModel::logMemberActivity(
                        'create bet',
                        $member,
                        $bets,
                        [
                            'target' => $nameProvider->username,
                            'activity' => 'Bet',
                            'device' => $nameProvider->device,
                            'ip' => $nameProvider->last_login_ip,
                        ],
                        "$nameProvider->username . ' Bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bets->game_info . ' idr '. $nameProvider->bet"
                    );

                    $result =  BetModel::where('game_id', $tokenRaw->gameCode)->first();
                }
            }
        }
        return [
            "status" => '0000',
            "balance" => $amount,
            "balanceTs"   => $result->created_at
        ];
    }

    // Get the information of the user
    protected function betInformation()
    {
        $data = $this->transaction;
        return (object)[
            "data" => $data,
        ];
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
