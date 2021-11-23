<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use App\Models\BetModel;
use App\Models\MembersModel;
use App\Models\UserLogModel;
use Firebase\JWT\JWT;

class GameHallController extends Controller
{
    // Token From Casino Provider 
    protected string $token;

    // Before this Controller is called, we need to check if the user is logged in
    public function __construct()
    {
        $this->token =  request()->token;
    }

    public function betGameHall()
    {
        /* $bonus = AppSetting::where('type', 'game')->pluck('value', 'id'); */
        $token = $this->betInformation($this->token);
        if ($token->amount < 0) {
            return response()->json([
                'success' => false,
                'message' =>  $token->creditMember
            ]);
        } else {
            $bets = BetModel::where('bet_id', $token->code)->first();
            if ($bets) {
                return [
                    "id" => $bets->id,
                    "success" => true,
                    "amout"   => $token->creditMember
                ];
            } else {
                $token->member->update([
                    'credit' => $token->amount,
                    'updated_at' => now(),
                    'bonus_referal' => 1212 /// ingat ini harus di ganti,
                ]);

                $bet = [
                    'constant_provider_id' => $token->provider === "game_hall" ? 5 : 0,
                    'bet_id' => $token->code,
                    'deskripsi' => 'Game Bet/Lose' . ' : ' . $token->amountbet,
                    'round_id' => $token->data->roundId,
                    'type' => 'Lose',
                    'bonus_daily_referal' => 100,
                    'game_id' => $token->data->gameId,
                    'bet' => $token->amountbet,
                    'game_info' => $token->data->type,
                    'created_at' => now(),
                    'credit' => $token->amount,
                    'updated_by' => $token->userId
                ];

                $this->insertBet($bet);
                $result =  BetModel::where('bet_id', $token->code)->first();
                return [
                    "id" => $result->id,
                    "success" => true,
                    "amout"   => $token->creditMember
                ];
            }
        }
    }

    public function resultGameHall()
    {
        /* $bonus = AppSetting::where('type', 'game')->pluck('value', 'id'); */
        $token = $this->betInformation($this->token);
        if ($token->amount < 0) {
            return response()->json([
                'success' => false,
                'message' =>  $token->creditMember
            ]);
        } else {
            $bets = BetModel::where('bet_id', $token->code)->first();
            if ($bets) {
                return [
                    "id" => $bets->id,
                    "success" => true,
                    "amout"   => $token->creditMember
                ];
            } else {
                $token->member->update([
                    'credit' => $token->amount,
                    'updated_at' => now(),
                    'bonus_referal' => 1212 /// ingat ini harus di ganti,
                ]);

                $bet = [
                    'constant_provider_id' => $token->provider === "game_hall" ? 5 : 0,
                    'bet_id' => $token->code,
                    'deskripsi' => 'Game Win' . ' : ' . $token->amount,
                    'round_id' => $token->data->roundId,
                    'type' => 'Win',
                    'game_id' => $token->data->gameId,
                    'bet' => 0, 
                    'win' => $token->amount,
                    'game_info' => $token->data->type,
                    'created_at' => now(),
                    'credit' => $token->amount,
                    'updated_by' => $token->userId
                ];

                $this->insertWin($bet);
                $result =  BetModel::where('bet_id', $token->code)->first();
                return [
                    "id" => $result->id,
                    "success" => true,
                    "amout"   => $token->creditMember
                ];
            }
        }
    }


    // Get the information of the user
    protected function betInformation(string $token)
    {
        $data = JWT::decode($token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        $user_id = $data->userId;
        $member =  MembersModel::where('id', $user_id)->first();
        $amountbet = $data->amount;
        $creditMember = $member->credit;
        $amount = $creditMember - $amountbet;

        return (object)[
            "data" => $data,
            "provider" => $data->provider,
            "code" => $data->code,
            "userId" => $user_id,
            "member" => $member,
            "amountbet" => $amountbet,
            "creditMember" => $creditMember,
            "amount"  => $amount
        ];
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

    protected function insertWin($bets)
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
}
