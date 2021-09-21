<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use App\Models\MembersModel;
use App\Models\BonusHistoryModel;
use App\Models\CancelBetModel;
use App\Models\BetModel;
use App\Models\UserLogModel;
use Carbon\Carbon;
use JWTAuth;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Response;

class ProviderController extends Controller
{
    private $token;

    public function bet(Request $request)
    {
        $this->token = $request->token;
        $data = JWT::decode($this->token,'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        $user_id = $data->userId;
        $member =  MembersModel::where('id', $user_id)->first();
        $amountbet = $data->amount;
        $amount = $member->credit - $data->amount;
        $bonus = AppSetting::where('type', 'game')->pluck('value', 'id');
        // bonus referral
        if($amount < 0 ){
            $res = [
                "success" => false,
                "amount"  => $member->credit
            ];
            return Response::json($res);
        }else{
            $member->update([
                'credit' => $amount,
                'created_at' => Carbon::now(),
                'bonus_referal' => $data->provider === 'Pragmatic' ? $member->bonus_referal + ($bonus[7] * $data->amount) : ($data->provider === 'Habanero' ? $member->bonus_referal + ($bonus[9] * $data->amount) : ($data->provider === 'Joker Gaming' ? $member->bonus_referal + ($bonus[11] * $data->amount) : ($data->provider === 'Spade Gaming' ? $member->bonus_referal + ($bonus[10] * $data->amount) : ($data->provider === 'Pg Soft' ? $member->bonus_referal + ($bonus[13] * $data->amount) : ($data->provider === 'Playtech' ? $member->bonus_referal + ($bonus[12] * $data->amount) : ''))))),
            ]);
            $success=[
                "success" =>  true,
                "amount" => $amount
            ];
            $bets = [
                'constant_provider_id' => $data->provider === 'Pragmatic' ? 1 : ($data->provider === 'Habanero' ? 2 : ($data->provider === 'Joker Gaming' ? 3 : ($data->provider === 'Spade Gaming' ? 4 : ($data->provider === 'Pg Soft' ? 5 : ($data->provider === 'Playtech' ? 6 : ''))))),
                'bet_id' => $data->code,
                'deskripsi' => 'Game Bet/Lose' . ' : ' . $amountbet,
                'round_id' => $data->roundId,
                'type' => 'Lose',
                'game_info' => $data->type,
                'bonus_daily_referal' => $data->provider === 'Pragmatic' ? $bonus[7] * $data->amount : ($data->provider === 'Habanero' ? $bonus[9] * $data->amount : ($data->provider === 'Joker Gaming' ? $bonus[11] * $data->amount : ($data->provider === 'Spade Gaming' ? $bonus[10] * $data->amount : ($data->provider === 'Pg Soft' ? $bonus[13] * $data->amount : ($data->provider === 'Playtech' ? $bonus[12] * $data->amount : ''))))),
                'game_id' => $data->gameId,
                'bet' => $amountbet,
                'created_at' => Carbon::now(),
                'credit' => $amount,
                'created_by' => $member->id
            ];
            $this->insertBet($bets);
            if ($member->referrer_id) {
                BonusHistoryModel::create([
                    'constant_bonus_id' => 3,
                    'created_by' => $member->referrer_id,
                    'created_at' => Carbon::now(),
                    'jumlah' => $data->provider === 'Pragmatic' ?  ($bonus[7] * $data->amount) : ($data->provider === 'Habanero' ?  ($bonus[9] * $data->amount) : ($data->provider === 'Joker Gaming' ?  ($bonus[11] * $data->amount) : ($data->provider === 'Spade Gaming' ?  ($bonus[10] * $data->amount) : ($data->provider === 'Pg Soft' ?  ($bonus[13] * $data->amount) : ($data->provider === 'Playtech' ?  ($bonus[12] * $data->amount) : ''))))),
                ]);
            }
            return Response::json($success);
        }
    }
    

    public function balance(Request $request) {
        $this->token = $request->token;
        $decoded = JWT::decode($this->token,'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        $userId = $decoded->userId;
        $member = MembersModel::where('id', $userId)->first();
        $res = [
            "success" => true,
            "amount" => $member->credit
        ];
        return Response::json($res);
    }

    public function cancelBet(Request $request)
    {
        $this->token = $request->token;
        $data = JWT::decode($this->token,'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        if($data->provider === 'Joker Gaming'){
            $member =  MembersModel::where('id', $data->userId)->first();
            $bets = BetModel::where('bet_id', $data->betId)->first();
            $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
                    ->where('bet_id', $data->betId)->first();
            $condition = CancelBetModel::where('cancel_id', $data->cancelId)->orWhere('bet_id', $data->betId)->first();
            if(!$bets){
                CancelBetModel::create([
                    'cancel_id' => $data->cancelId,
                    'bet_id' => $data->betId,
                    'created_by' => $data->userId,
                    'created_at' => Carbon::now(),
                ]);
                $res = [
                    "success" => false,
                    "amount"  => $member->credit
                ];
                return Response::json($res);
            }
            if($condition){
                $res = [
                    "message" => "The CancelBet already existed",
                    "success" => true,
                    "amount"  => $member->credit
                ];
                return Response::json($res);
            }else{
                $cancelCredit = $member->credit + $bets->bet;
                $member->update([
                    'credit' => $cancelCredit
                ]);
                CancelBetModel::create([
                    'cancel_id' => $data->cancelId,
                    'bet_id' => $data->betId,
                    'created_by' => $data->userId,
                    'created_at' => Carbon::now(),
                ]);
                $res = [
                    "message" => "Success",
                    "success" => true,
                    "amount"  => $cancelCredit
                ];
                UserLogModel::logMemberActivity(
                    'Cancel bet',
                    $member,
                    $bets,
                    [
                        'target' => $member->username,
                        'activity' => 'Cancel bet',
                        'device' => $member->device,
                        'ip' => $member->last_login_ip,
                    ],
                    "$member->username . ' Cancel on ' . $nameProvider->constant_provider_name . ' type ' .  $nameProvider->game_info . ' idr '. $nameProvider->bet"
                );
                return Response::json($res);
            }
        } else {
            $member =  MembersModel::where('id', $data->userId)->first();
            $bets = BetModel::where('bet_id', $data->betId)->first();
            $condition = CancelBetModel::where('cancel_id', $data->cancelId)->orWhere('bet_id', $data->betId)->first();
            $cancelCredit = $member->credit + $bets->bet;
            if(!$bets){
                $res = [
                    "success" => false,
                    "amount"  => $member->credit,
                    "message" => "Bet not found",
                ];
                return Response::json($res);
            }
            if($condition){
                $res = [
                    "id"      => $bets->bet_id,
                    "message" => "The CancelBet already existed",
                    "success" => true,
                    "amount"  => $member->credit
                ];
                return Response::json($res);
            }else{
                $member->update([
                    'credit' => $cancelCredit
                ]);
                CancelBetModel::create([
                    'cancel_id' => $data->cancelId,
                    'bet_id' => $data->betId,
                    'created_by' => $data->userId,
                    'created_at' => Carbon::now(),
                ]);
                $res = [
                    "id"      => $bets->bet_id,
                    "message" => "Success",
                    "success" => true,
                    "amount"  => $cancelCredit
                ];
                UserLogModel::logMemberActivity(
                    'Cancel bet',
                    $member,
                    $bets,
                    [
                        'target' => $member->username,
                        'activity' => 'Cancel bet',
                        'device' => $member->device,
                        'ip' => $member->last_login_ip,
                    ],
                    "$member->username . ' Cancel on ' . $nameProvider->constant_provider_name . ' type ' .  $nameProvider->game_info . ' idr '. $nameProvider->bet"
                );
                return Response::json($res);
            }
        }
    }

    public function result(Request $request)
    {
        $this->token = $request->token;
        $data = JWT::decode($this->token,'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));

        // $code = $data->code;
        // $bets = BetModel::where('bet_id', $code)->first();
        $user_id = $data->userId;
        $member =  MembersModel::where('id', $user_id)->first();
        $amount = $member->credit + $data->amount;

        $member->update([
            'credit' => $amount
        ]);
        if($data->amount <= 1 ){
            $res = [
                "success" => true,
                "amount"  => $member->credit
            ];
            return Response::json($res);
        }else{
            $win = [
                'constant_provider_id' => $data->provider === 'Pragmatic' ? 1 : ($data->provider === 'Habanero' ? 2 : ($data->provider === 'Joker Gaming' ? 3 : ($data->provider === 'Spade Gaming' ? 4 : ($data->provider === 'Pg Soft' ? 5 : ($data->provider === 'Playtech' ? 6 : ''))))),
                'bet_id' => $data->code,
                'round_id' => $data->roundId,
                'deskripsi' => 'Game Win' . ' : ' . $data->amount,
                'game_id' => $data->gameId,
                'type' => 'Win',
                'game_info' => $data->type,
                'win' =>  $data->amount,
                'bet' => 0,
                'player_wl' => 0,
                'created_at' => Carbon::now(),
                'credit' => $amount,
                'created_by' => $member->id
            ];
            $this->insertWin($win);
            $res = [
                "success" => true,                             
                "amount"  => $amount
            ];
            return Response::json($res);
        }


        // if($bets != $code){
        //     $bets->update([
        //         'credit' =>  $amount,
        //         'win' =>  $data->amount,
        //         'player_wl' => $data->amount - $bets->bet
        //     ]);
        //     $res = [
        //         "success" => true,
        //         "amount"  => $amount
        //     ];
        //     return Response::json($res);
        // }else{
        //     $member->update([
        //         'credit' => $amount
        //     ]);
        //     $res = [
        //         "success" => true,
        //         "amount"  => $amount
        //     ];
        //     return Response::json($res);
        // }

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

            // activity('create_bet')->causedBy($bet)
            // ->performedOn($bet)
            // ->withProperties([
            //     'target' => $nameProvider->username,
            //     'activity' => 'Bet',
            // ])
            // ->log($nameProvider->username . ' bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bet->game_info . ' idr '. $nameProvider->bet);
    }
    protected function insertWin($win)
    {
            $win = BetModel::create($win);
            # log activity
            $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
                ->leftJoin('members', 'members.id', '=', 'bets.created_by')
                ->where('bets.id', $win->id)->first();

            $member =  MembersModel::where('id', $win->created_by)->first();
            UserLogModel::logMemberActivity(
                'create win',
                $member,
                $win,
                [
                    'target' => $nameProvider->username,
                    'activity' => 'Win',
                    'device' => $nameProvider->device,
                    'ip' => $nameProvider->last_login_ip,
                ],
                "$nameProvider->username . ' Win on ' . $nameProvider->constant_provider_name . ' type ' .  $win->game_info . ' idr '. $nameProvider->win"
            );
            // activity('create_bet')->causedBy($win)
            // ->performedOn($win)
            // ->withProperties([
            //     'target' => $nameProvider->username,
            //     'activity' => 'Win',
            // ])
            // ->log($nameProvider->username . ' Win on ' . $nameProvider->constant_provider_name . ' type ' .  $win->game_info . ' idr '. $nameProvider->win);
    }

    public function getBetHistorySpadeGaming(Request $request)
    {
        $url = 'https://api-egame-staging.sgplay.net/api/';
        $body = array(
            "beginDate" => $request->beginDate,
            "endDate" => $request->endDate,
            "pageIndex" => $request->pageIndex,
            "serialNo" => $request->serialNo,
            "merchantCode" => $request->merchantCode,
        );
        $headers = array(
            'Datatype' => 'JSON',
            'api' => 'getBetHistory',
            'Content-Type' => 'application/json',
        );
        $client = new Client();
        $res = $client->post(
            $url,
            array(
                'headers' => $headers,
                'json' => $body
            )
        );
        $response = $res->getBody();
        $data = json_decode($response->getContents());
        return Response::json($data);
    }

    // detail
    public function detailSpadeGaming(Request $request)
    {
        $url = 'https://lobby-egame-staging.sgplay.net/A88/createToken/';
        $body = array(
            "ticketId" => $request->ticketId,
            "acctId" => $request->acctId,
            "action" => $request->action,
            "token" => $request->token,
            // "merchantCode" => $request->merchantCode,
        );
        $headers = array(
            'Datatype' => 'JSON',
            // 'api' => 'getBetHistory',
            'Content-Type' => 'application/json',
        );
        $client = new Client();
        $res = $client->post(
            $url,
            array(
                'headers' => $headers,
                'json' => $body
            )
        );
        $response = $res->getBody();
        $data = json_decode($response->getContents());
        return Response::json($data);
    }

    public function betJoker(Request $request)
    {
        $this->token = $request->token;
        $data = JWT::decode($this->token,'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        $user_id = $data->userId;
        $member =  MembersModel::where('id', $user_id)->first();
        $amountbet = $data->amount;
        $creditMember = $member->credit ;
        $amount = $creditMember - $amountbet;
        // dd($amount);
        $bonus = AppSetting::where('type', 'game')->pluck('value', 'id');
        if($amount < 0 ){
            $res = [
                "success" => false,
                "amount"  => $creditMember
            ];
            return Response::json($res);
        }else{
            $condition = CancelBetModel::where('bet_id', $data->code)->first();
            if($condition){
                $successCon=[
                    "success" =>  true,
                    "amount" => $creditMember * 1
                ];
                return Response::json($successCon);
            }
            $bets = BetModel::where('bet_id', $data->code)->first();
            if($bets){
                $success=[
                    "id"    => $bets->id,
                    "success" =>  true,
                    "amount" => $creditMember
                ];
            }else{
                $member->update([
                    'credit' => $amount,
                    'created_at' => Carbon::now(),
                    'bonus_referal' => $data->provider === 'Pragmatic' ? $member->bonus_referal + ($bonus[7] * $data->amount) : ($data->provider === 'Habanero' ? $member->bonus_referal + ($bonus[9] * $data->amount) : ($data->provider === 'Joker Gaming' ? $member->bonus_referal + ($bonus[11] * $data->amount) : ($data->provider === 'Spade Gaming' ? $member->bonus_referal + ($bonus[10] * $data->amount) : ($data->provider === 'Pg Soft' ? $member->bonus_referal + ($bonus[13] * $data->amount) : '')))),
                ]);
                $bet = [
                    'constant_provider_id' => $data->provider === 'Pragmatic' ? 1 : ($data->provider === 'Habanero' ? 2 : ($data->provider === 'Joker Gaming' ? 3 : ($data->provider === 'Spade Gaming' ? 4 : ($data->provider === 'Pg Soft' ? 5 : ($data->provider === 'Playtech' ? 6 : ''))))),
                    'bet_id' => $data->code,
                    'deskripsi' => 'Game Bet/Lose' . ' : ' . $amountbet,
                    'round_id' => $data->roundId,
                    'type' => 'Lose',
                    'bonus_daily_referal' => $data->provider === 'Pragmatic' ? $bonus[7] * $data->amount : ($data->provider === 'Habanero' ? $bonus[9] * $data->amount : ($data->provider === 'Joker Gaming' ? $bonus[11] * $data->amount : ($data->provider === 'Spade Gaming' ? $bonus[10] * $data->amount : ($data->provider === 'Pg Soft' ? $bonus[13] * $data->amount : ($data->provider === 'Playtech' ? $bonus[12] * $data->amount : ''))))),
                    'game_id' => $data->gameId,
                    'bet' => $amountbet,
                    'game_info' => $data->type,
                    'created_at' => Carbon::now(),
                    'credit' => $amount,
                    'created_by' => $member->id
                ];
                $this->insertBet($bet);
                $bets = BetModel::where('bet_id', $data->code)->first();
                $success=[
                    "id"    => $bets->id,
                    "success" =>  true,
                    "amount" => $amount
                ];
                if ($member->referrer_id) {
                    BonusHistoryModel::create([
                        'constant_bonus_id' => 3,
                        'created_by' => $member->referrer_id,
                        'created_at' => Carbon::now(),
                        'jumlah' => $data->provider === 'Pragmatic' ?  ($bonus[7] * $data->amount) : ($data->provider === 'Habanero' ?  ($bonus[9] * $data->amount) : ($data->provider === 'Joker Gaming' ?  ($bonus[11] * $data->amount) : ($data->provider === 'Spade Gaming' ?  ($bonus[10] * $data->amount) : ($data->provider === 'Pg Soft' ?  ($bonus[13] * $data->amount) : ($data->provider === 'Playtech' ?  ($bonus[12] * $data->amount) : ''))))),
                    ]);
                }
            }
            return Response::json($success);
        }
    }

    // bet pragmatik
    public function betPragmatic(Request $request)
    {
        $this->token = $request->token;
        $data = JWT::decode($this->token,'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        $user_id = $data->userId;
        $member =  MembersModel::where('id', $user_id)->first();
        $amountbet = $data->amount;
        $creditMember = $member->credit ;
        $amount = $creditMember - $amountbet;
        // dd($amount);
        $bonus = AppSetting::where('type', 'game')->pluck('value', 'id');
        if($amount < 0 ){
            $res = [
                "success" => false,
                "amount"  => $creditMember
            ];
            return Response::json($res);
        }else{
            $bets = BetModel::where('bet_id', $data->code)->first();
            if($bets){
                $success=[
                    "id"    => $bets->id,
                    "success" =>  true,
                    "amount" => $creditMember
                ];
            }else{
                $member->update([
                    'credit' => $amount,
                    'created_at' => Carbon::now(),
                    'bonus_referal' => $data->provider === 'Pragmatic' ? $member->bonus_referal + ($bonus[7] * $data->amount) : ($data->provider === 'Habanero' ? $member->bonus_referal + ($bonus[9] * $data->amount) : ($data->provider === 'Joker Gaming' ? $member->bonus_referal + ($bonus[11] * $data->amount) : ($data->provider === 'Spade Gaming' ? $member->bonus_referal + ($bonus[10] * $data->amount) : ($data->provider === 'Pg Soft' ? $member->bonus_referal + ($bonus[13] * $data->amount) : '')))),
                ]);
                $bet = [
                    'constant_provider_id' => $data->provider === 'Pragmatic' ? 1 : ($data->provider === 'Habanero' ? 2 : ($data->provider === 'Joker Gaming' ? 3 : ($data->provider === 'Spade Gaming' ? 4 : ($data->provider === 'Pg Soft' ? 5 : ($data->provider === 'Playtech' ? 6 : ''))))),
                    'bet_id' => $data->code,
                    'deskripsi' => 'Game Bet/Lose' . ' : ' . $amountbet,
                    'round_id' => $data->roundId,
                    'type' => 'Lose',
                    'bonus_daily_referal' => $data->provider === 'Pragmatic' ? $bonus[7] * $data->amount : ($data->provider === 'Habanero' ? $bonus[9] * $data->amount : ($data->provider === 'Joker Gaming' ? $bonus[11] * $data->amount : ($data->provider === 'Spade Gaming' ? $bonus[10] * $data->amount : ($data->provider === 'Pg Soft' ? $bonus[13] * $data->amount : ($data->provider === 'Playtech' ? $bonus[12] * $data->amount : ''))))),
                    'game_id' => $data->gameId,
                    'bet' => $amountbet,
                    'game_info' => $data->type,
                    'created_at' => Carbon::now(),
                    'credit' => $amount,
                    'created_by' => $member->id
                ];
                $this->insertBet($bet);
                $bets = BetModel::where('bet_id', $data->code)->first();
                $success=[
                    "id"    => $bets->id,
                    "success" =>  true,
                    "amount" => $amount
                ];
                if ($member->referrer_id) {
                    BonusHistoryModel::create([
                        'constant_bonus_id' => 3,
                        'created_by' => $member->referrer_id,
                        'created_at' => Carbon::now(),
                        'jumlah' => $data->provider === 'Pragmatic' ?  ($bonus[7] * $data->amount) : ($data->provider === 'Habanero' ?  ($bonus[9] * $data->amount) : ($data->provider === 'Joker Gaming' ?  ($bonus[11] * $data->amount) : ($data->provider === 'Spade Gaming' ?  ($bonus[10] * $data->amount) : ($data->provider === 'Pg Soft' ?  ($bonus[13] * $data->amount) : ($data->provider === 'Playtech' ?  ($bonus[12] * $data->amount) : ''))))),
                    ]);
                }
            }
            return Response::json($success);
        }
    }

    // result pragmatic
    public function resultPragmatic(Request $request)
    {
        $this->token = $request->token;
        $data = JWT::decode($this->token,'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        $user_id = $data->userId;
        $member =  MembersModel::where('id', $user_id)->first();
        $creditMember = $member->credit;
        $amount = $member->credit + $data->amount;


        $result = BetModel::where('bet_id', $data->code)->first();
        if($result){
            $res=[
                "id"    => $result->id,
                "success" =>  true,
                "amount" => $creditMember
            ];
        }else{
            $member->update([
                'credit' => $amount
            ]);
            $win = [
                'constant_provider_id' => $data->provider === 'Pragmatic' ? 1 : ($data->provider === 'Habanero' ? 2 : ($data->provider === 'Joker Gaming' ? 3 : ($data->provider === 'Spade Gaming' ? 4 : ($data->provider === 'Pg Soft' ? 5 : ($data->provider === 'Playtech' ? 6 : ''))))),
                'bet_id' => $data->code,
                'round_id' => $data->roundId,
                'deskripsi' => 'Game Win' . ' : ' . $data->amount,
                'game_id' => $data->gameId,
                'type' => 'Win',
                'win' =>  $data->amount,
                'bet' => 0,
                'game_info' => $data->type,
                'player_wl' => 0,
                'created_at' => Carbon::now(),
                'credit' => $amount,
                'created_by' => $member->id
            ];
            $this->insertWin($win);
            $result = BetModel::where('bet_id', $data->code)->first();
            $res = [
                "id"    => $result->id,
                "success" => true,
                "amount"  => $amount
            ];
        }
        return Response::json($res);
    }
    // result playtech
    public function resultPlaytech(Request $request)
    {
        $this->token = $request->token;
        $data = JWT::decode($this->token,'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        $user_id = $data->userId;
        $member =  MembersModel::where('id', $user_id)->first();
        $creditMember = $member->credit;
        $amount = $member->credit + $data->amount;


        $exist = BetModel::where('constant_provider_id', 6)->where('round_id', $data->roundId)->where('bet', '>', 0)->first();
        $result = BetModel::where('bet_id', $data->code)->first();
        if(is_null($exist)){
            $res=[
                "success" =>  false,
                "amount" => $creditMember
            ];
        }elseif($result){
            $res=[
                "id"    => $result->id,
                "success" =>  true,
                "amount" => $creditMember
            ];
        }else{
            $member->update([
                'credit' => $amount
            ]);
            $win = [
                'constant_provider_id' => $data->provider === 'Pragmatic' ? 1 : ($data->provider === 'Habanero' ? 2 : ($data->provider === 'Joker Gaming' ? 3 : ($data->provider === 'Spade Gaming' ? 4 : ($data->provider === 'Pg Soft' ? 5 : ($data->provider === 'Playtech' ? 6 : ''))))),
                'bet_id' => $data->code,
                'round_id' => $data->roundId,
                'deskripsi' => 'Game Win' . ' : ' . $data->amount,
                'game_id' => $data->gameId,
                'type' => 'Win',
                'win' =>  $data->amount,
                'bet' => 0,
                'game_info' => $data->type,
                'player_wl' => 0,
                'created_at' => Carbon::now(),
                'credit' => $amount,
                'url_detail' => $data->url,
                'created_by' => $member->id
            ];
            $this->insertWin($win);
            $result = BetModel::where('bet_id', $data->code)->first();
            $res = [
                "id"    => $result->id,
                "success" => true,
                "amount"  => $amount
            ];
        }
        return Response::json($res);
    }

    public function gameHistoryPragmatic(Request $request)
    {
        $url = 'https://api.prerelease-env.biz/IntegrationService/v3/http/HistoryAPI/';
        $secureLogin = 'subbetap_cikatech';
        $secretKey = 'testKey';
        $options = 'GetFrbDetails,GetLines,GetDataTypes';
        $raw = '';
        $raw .= 'gameId=' . 'vs20bonzgold' . '&' . 'playerId=' . 19 . '&roundId=' . 2147483647 . '&secureLogin=' . $secureLogin . $secretKey;
        $hash = md5($raw);
        $array = array(
            "secureLogin" => $secureLogin,
            "playerId" => 19,
            "gameId" => 'vs20bonzgold',
            "roundId" => 2147483647,
            "hash" => $hash,
        );
        $client = new Client([
            'base_uri' => $url,
        ]);
        $response = $client->post(
            'OpenHistoryExtended/',
            array(
                'form_params' => $array
            )
        );
        $body = $response->getBody();
        return $body;
    }



    // public function getGameRound(Request $request)
    // {
    //     $url = 'https://api.prerelease-env.biz/IntegrationService/v3/http/HistoryAPI/';
    //     $secureLogin = 'subbetap_cikatech';
    //     $secretKey = 'testKey';
    //     $options = 'GetFrbDetails,GetLines,GetDataTypes';
    //     $raw = '';
    //     $raw .= 'datePlayed=' . '2021-08-07' . '&' . 'gameId=' . 'vs20bonzgold' . '&hour=' . 24 . '&playerId=' . 19 . '&secureLogin=' . $secureLogin . '&timeZone=' . 'GMT+07:00' . $secretKey  ;
    //     $hash = md5($raw);
    //     $array = array(
    //         "secureLogin" => $secureLogin,
    //         "playerId" => 19,
    //         "gameId" => 'vs20bonzgold',
    //         "hour" => 24,
    //         "datePlayed" => '2021-08-07',
    //         "timeZone" => 'GMT+07:00',
    //         "hash" => $hash,
    //     );
    //     $client = new Client([
    //         'base_uri' => $url,
    //     ]);
    //     $response = $client->post(
    //         'GetGameRounds/',
    //         array(
    //             'form_params' => $array
    //         )
    //     );
    //     $body = $response->getBody();
    //     return $body;
    // }


}