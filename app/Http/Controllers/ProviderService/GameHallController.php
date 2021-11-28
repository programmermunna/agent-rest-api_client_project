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
        if ($token->amount < 0) {
            return response()->json([
                'success' => false,
                'message' =>  $token->creditMember
            ]);
        } else {
            // check if bet already exist
            $bets = BetModel::where('bet_id', $token->data->txns[0]->platformTxId)->first();
            if ($bets) {
                return [
                    "id" => $bets->id,
                    "success" => true,
                    "amout"   => $token->creditMember,
                    "message"   => 'Bet already exist'
                ];
            } else {
                // update credit to table member
                $token->member->update([
                    'credit' => $token->amount,
                    'updated_at' => $token->data->txns[0]->betTime,
                ]);

                $bet = [
                    'updated_by' => $token->userId,
                    'bet_id' => $token->data->txns[0]->platformTxId,
                    'game_info' => 'live_casino',
                    'game_id' => $token->data->txns[0]->gameCode,
                    'round_id' => $token->data->txns[0]->roundId,
                    'type' => 'Bet',
                    'game' => $token->data->txns[0]->gameName,
                    'bet' => $token->amountbet,
                    'game_info' => $token->data->txns[0]->gameType,
                    'created_at' => $token->data->txns[0]->betTime,
                    'constant_provider_id' => 7,
                    'deskripsi' => 'Game Bet/Lose' . ' : ' . $token->amountbet,
                ];
                // insert bet to table bet
                $this->insertBet($bet);
                $result =  BetModel::where('game_id', $token->data->txns[0]->gameCode)->first();
                return [
                    "status" => '0000',
                    "balance" => $token->amount,
                    "balanceTs"   => $result->created_at
                ];
            }
        }
    }
    protected function insertBet($bets)
    {
        $bet = BetModel::create($bets);
        # log activity
        $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
            ->leftJoin('members', 'members.id', '=', 'bets.created_by')
            ->where('bets.id', $bet->id)->first();
        $member =  MembersModel::where('id', $bet->created_by)->first();
        UserLogModel::logMemberActivity(
            'create bet',
            $member,
            $bet,
            [
                'target' => $nameProvider->username,
                'activity' => 'Bet',
                'device' => $nameProvider->device,
                'ip' => $nameProvider->last_login_ip,
            ],
            "$nameProvider->username . ' Bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bet->game_info . ' idr '. $nameProvider->bet"
        );
    }

    // Get the information of the user
    protected function betInformation()
    {
        $data = $this->transaction;
        $user_id = $data->txns[0]->userId;
        $member =  MembersModel::where('id', $user_id)->first();
        $amountbet = $data->txns[0]->betAmount;
        $creditMember = $member->credit;
        $amount = $creditMember - $amountbet;

        return (object)[
            "data" => $data,
            "userId" => $user_id,
            "member" => $member,
            "amountbet" => $amountbet,
            "creditMember" => $creditMember,
            "amount"  => $amount
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
