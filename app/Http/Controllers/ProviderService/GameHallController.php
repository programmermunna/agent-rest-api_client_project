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
                return $this->Bet();
                break;

            case 'settle':
                return $this->Settle();
                break;

            case 'cancelBet':
                return $this->CancelBet();
                break;

            case 'adjustBet':
                return $this->AdjustBet();
                break;

            case 'adjustBet':
                return $this->AdjustBet();
                break;

            case 'voidBet':
                return $this->VoidBet();
                break;

            case 'voidSettle':
                return $this->VoidSettle();
                break;

            case 'unvoidSettle':
                return $this->UnVoidSettle();
                break;

            case 'refund':
                return $this->RefunBet();
                break;

            case 'unvoidBet':
                return $this->UnVoidBet();
                break;

            case 'tip':
                return $this->Tip();
                break;

            case 'give':
                return $this->Give();
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
                        "status" => '0000',
                        "balance" => $creditMember,
                        "balanceTs"   => now() 
                    ];
                } else {
                    // update credit to table member
                    $member->update([
                        'credit' => $amount,
                        'updated_at' => $tokenRaw->betTime,
                    ]);
                    ray($tokenRaw->platform);
                    $bets = BetModel::create([
                        'platform'  => $tokenRaw->platform,
                        'created_by' => $tokenRaw->userId,
                        'updated_by' => $tokenRaw->userId,
                        'bet_id' => $tokenRaw->platformTxId,
                        'game_info' => 'live_casino',
                        'game_id' => $tokenRaw->gameCode,
                        'round_id' => $tokenRaw->roundId,
                        'type' => 'Bet',
                        'game' => $tokenRaw->gameName,
                        'bet' => $amountbet,
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
        // call betInformation
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $member =  MembersModel::where('id', $tokenRaw->userId)->first();
            $creditMember = $member->credit;
            BetModel::query()->where('bet_id', '=', $tokenRaw->platformTxId)
                ->update([
                    'type' => 'Cancel'
                ]);
        }
        return [
            "status" => '0000',
            "balance" => $creditMember,
            "balanceTs"   => now()
        ];
    }

    public function VoidBet()
    {
        // call betInformation
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $amountbet = $tokenRaw->betAmount;
            $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
            if ($bets == null) {
                return [
                    "status" => '0000',
                ];
            } else {
                $bets->update([
                    'type' => 'Void',
                    'bet' => $amountbet * $tokenRaw->gameInfo->odds,
                    'updated_at' => $tokenRaw->updateTime,
                ]);
            }
        }
        return [
            "status" => '0000',
        ];
    }

    public function SettleBet()
    {
    }

    public function AdjustBet()
    {
        // call betInformation
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $member =  MembersModel::where('id', $tokenRaw->userId)->first();
            $creditMember = $member->credit;
            $amountbet = $tokenRaw->betAmount;
            $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
            if ($bets == null) {
                return [
                    "status" => '0000',
                ];
            } else {
                $bets->update([
                    'bet' => $amountbet * $tokenRaw->gameInfo->odds,
                    'updated_at' => $tokenRaw->updateTime,
                ]);
            }
        }
        return [
            "status" => '0000',
            "balance" => $creditMember,
            "balanceTs"   => now()
        ];
    }

    public function UnVoidBet()
    {
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
            if ($bets == null) {
                return [
                    "status" => '0000',
                ];
            } else {
                $bets->update([
                    'type' => 'Bet',
                    'updated_at' => $tokenRaw->updateTime,
                ]);
            }
        }
        return [
            "status" => '0000',
        ];
    }

    public function RefunBet()
    {
        // call betInformation
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
            $member =  MembersModel::where('id', $tokenRaw->userId)->first();
            if ($bets == null) {
                return [
                    "status" => '0000',
                    "balance" => $member->credit,
                    "balanceTs"   => now()
                ];
            } else {

                $amountWin = $tokenRaw->winAmount;
                $amountBet = $tokenRaw->betAmount;
                $creditMember = $member->credit;

                // calculate balance member
                $amount = $creditMember + $amountBet - $amountWin;

                // update credit to table member
                $member->update([
                    'credit' => $amount,
                ]);

                $bets->update([
                    'type' => 'Refund',
                    'created_at' => $tokenRaw->betTime,
                    'updated_at' => $tokenRaw->updateTime,
                    'deskripsi' => 'Game Refund',
                ]);
            }
        }
        return [
            "status" => '0000',
            "balance" => $amount,
            "balanceTs"   => now()
        ];
    }

    public function Settle()
    {
        // call betInformation
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {

            $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)
                ->where('platform' , $tokenRaw->platform)
                ->where('type' , 'Bet')
                ->first();

            $member =  MembersModel::where('id', $tokenRaw->userId)->first();
            if ($bets == null) {
                return [
                    "status" => '0000',
                    "balance" => $member->credit,
                    "balanceTs"   => now()
                ];
            } else {

                $amountWin = $tokenRaw->winAmount;
                $creditMember = $member->credit;
                $amount = $creditMember + $amountWin;
                // update credit to table member
                $member->update([
                    'credit' => $amount,
                    'updated_at' => $tokenRaw->betTime,
                ]);

                // check win / lose
                if ($tokenRaw->winAmount == 0) {
                    $bets->update([
                        'type' => 'Settle',
                        'created_at' => $tokenRaw->betTime,
                        'updated_at' => $tokenRaw->updateTime,
                        'deskripsi' => 'Game Bet/Lose' . ' : ' . $tokenRaw->betAmount,
                    ]);
                } else {
                    $bets->update([
                        'type' => 'Settle',
                        'win' => $amountWin,
                        'created_at' => $tokenRaw->betTime,
                        'updated_at' => $tokenRaw->updateTime,
                        'deskripsi' => 'Game win' . ' : ' . $amountWin,
                    ]);
                }
            }
        }
        return [
            "status" => '0000',
            "balance" => $amount,
            "balanceTs"   => now()
        ];
    }

    public function UnSettle()
    {
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $amountbet = $tokenRaw->betAmount;
            $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
            if ($bets == null) {
                return [
                    "status" => '0000',
                ];
            } else {
                $bets->update([
                    'type' => 'Bet',
                    'bet' => $amountbet * $tokenRaw->gameInfo->odds,
                    'updated_at' => $tokenRaw->updateTime,
                ]);
            }
        }
        return [
            "status" => '0000',
        ];
    }

    public function VoidSettle()
    {
        // call betInformation
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $amountbet = $tokenRaw->betAmount;
            $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
            if ($bets == null) {
                return [
                    "status" => '0000',
                ];
            } else {
                $bets->update([
                    'type' => 'Void',
                    'bet' => $amountbet * $tokenRaw->gameInfo->odds,
                    'updated_at' => $tokenRaw->updateTime,
                ]);
            }
        }
        return [
            "status" => '0000',
        ];
    }

    public function UnVoidSettle()
    {
        // call betInformation
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $amountbet = $tokenRaw->betAmount;
            $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
            if ($bets == null) {
                return [
                    "status" => '0000',
                ];
            } else {
                $bets->update([
                    'type' => 'Bet',
                    'updated_at' => $tokenRaw->updateTime,
                ]);
            }
        }
        return [
            "status" => '0000',
        ];
    }

    public function Give()
    {
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $member =  MembersModel::where('id', $tokenRaw->userId)->first();
            $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();

            $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
                ->leftJoin('members', 'members.id', '=', 'bets.created_by')
                ->where('bets.id', $bets->id)->first();

            if ($bets == null) {
                return [
                    "status" => '0000',
                ];
            } else {
                $bonusAmount = $tokenRaw->amount;
                $creditMember = $member->credit;
                $amount = $creditMember + $bonusAmount;
                $member->update([
                    'credit' => $amount,
                    'updated_at' => now(),
                ]);

                UserLogModel::logMemberActivity(
                    'Member Bonus',
                    $member,
                    $bets,
                    [
                        'target' => $nameProvider->username,
                        'activity' => 'Credit Bonus',
                        'device' => $nameProvider->device,
                        'ip' => $nameProvider->last_login_ip,
                    ],
                    "$nameProvider->username Received Bonus On $nameProvider->constant_provider_name . ' type ' .  $bets->game_info . ' idr '. $nameProvider->bet"
                );
            }
        }
        return [
            "status" => '0000',
        ];
    }

    public function Tip()
    {
        // call betInformation
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $tipAmount = $tokenRaw->tip;
            $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
            $member =  MembersModel::where('id', $tokenRaw->userId)->first();
            $creditMember = $member->credit;
            $amount = $creditMember + $tipAmount;
            // update credit to table member
            $member->update([
                'credit' => $amount,
                'updated_at' => now(),
            ]);
            if ($bets == null) {
                return [
                    "status" => '0000',
                    "balance" => 0.0,
                    "balanceTs" => now(),
                ];
            }
        }
        return [
            "status" => '0000',
            "balance" => $amount ?? 0.0,
            "balanceTs" => now()
        ];
    }

    public function CancelTip()
    {
        // call betInformation
        $token = $this->betInformation();
        foreach ($token->data->txns as $tokenRaw) {
            $member =  MembersModel::where('id', $tokenRaw->userId)->first();
            $creditMember = $member->credit;
            BetModel::query()->where('bet_id', '=', $tokenRaw->platformTxId)
                ->update([
                    'type' => 'Cancel'
                ]);
        }
        return [
            "status" => '0000',
            "desc" => 'succes',
            "balance" => $creditMember,
            "balanceTs"   => now()
        ];
    }
}
