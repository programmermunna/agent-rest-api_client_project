<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembersModel;
use App\Models\BetModel;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

class QueenmakerController extends Controller
{
    public function getDebitQueenMaker()
    {
        $token =  JWT::decode(request()->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        // check if any token
        if (!$token && is_null($token)) {
            return response()->json([ 
                "err" => 10,
                "errdesc" => "Invalid or expired token"
            ]);
        }else{
            foreach ($token->transactions as $tokenRaw) {
                $member = MembersModel::find($tokenRaw->userid);
                // calculate balance
                $balance = $member->credit - $tokenRaw->amt;
                if ($balance < 0) {
                    return response()->json([ 
                        "err" => 100,
                        "errdesc" => "Insufficient funds to perform the operation"
                    ]);
                }else{
                    // create transaction on debit
                    $bet = BetModel::create([
                        'bet_id' => $tokenRaw->ptxid,
                        'refptxid' => $tokenRaw->refptxid,
                        'bet' => $tokenRaw->amt,
                        'platform' => $tokenRaw->gpcode,
                        'game_id' => $tokenRaw->gamecode,
                        'game' => $tokenRaw->gamename,
                        'game_info' => $tokenRaw->gametype == 0 ? 'slot' : 'TableGame',
                        'type' => $tokenRaw->txtype === 500 ? 'Bet' : ($tokenRaw->txtype === 510  ? 'Win' : ($tokenRaw->txtype === 511  ? 'Jackpot' : ($tokenRaw->txtype === 520 ? 'Lose' : ($tokenRaw->txtype === 530 ? 'Freebet' : ($tokenRaw->txtype === 540 ? 'Tie' : ($tokenRaw->txtype === 560 ? 'Cancel' : 'End_round')))))),
                        'round_id' => $tokenRaw->roundid,
                        'deskripsi' => $tokenRaw->txtype === 500 ? 'Game Bet' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 510  ? 'Game Win' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 511  ? 'Game Jackpot' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 520 ? 'Game Lose' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 530 ? 'Game Freebet' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 540 ? 'Game Tie' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 560 ? 'Cancel' : 'End_round')))))),
                        'created_at' => $tokenRaw->timestamp,
                        'created_by' => $tokenRaw->userid,
                        'constant_provider_id' => 9,
                    ]);
                    // update credit 
                    $member->update([
                        'credit' => $balance
                    ]);
                }
            }
            return response()->json([ 
                'transactions' => [
                    ([
                        'txid' => $bet->id,
                        'ptxid' => $bet->bet_id,
                        'bal' => $member->credit,
                        'cur' => 'IDR',
                        'dup' => false,
                    ])
                ]
            ]);
        }
    }
    public function getCreditQueenMaker()
    {
        $data = [];
        $token =  JWT::decode(request()->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        // check if any token
        if (!$token && is_null($token)) {
            return response()->json([ 
                "err" => 10,
                "errdesc" => "Token has expired"
            ]);
        }else{
            foreach ($token->transactions as $tokenRaw) {
                // transaction on credit
                $bet = BetModel::where('bet_id', '=', $tokenRaw->ptxid)
                                ->first();
                $cancelBet = BetModel::where('bet_id', '=', $tokenRaw->ptxid)
                                ->where('refptxid', '=', $tokenRaw->refptxid)
                                ->where('type', '=', 'Bet')
                                ->first();
                $member = MembersModel::find($tokenRaw->userid);
                if ($cancelBet) {
                    $cancelBet->update([
                        'type' => 'Cancel'
                    ]);
                    // update credit 
                    $balance = $member->credit + $tokenRaw->amt;
                    $member->update([
                        'credit' => $balance
                    ]);
                    array_push($data, [
                        'txid' => $cancelBet->id,
                        'ptxid' => $cancelBet->bet_id,
                        'bal' => $member->credit,
                        'cur' => 'IDR',
                        'dup' => false,
                    ]);
                }elseif ($bet) {
                    array_push($data, [
                        'txid' => $bet->id,
                        'ptxid' => $bet->bet_id,
                        'bal' => $member->credit,
                        'cur' => 'IDR',
                        'dup' => true,
                    ]);
                }elseif (!$cancelBet) {
                    array_push($data, [
                        "txid"  => $tokenRaw->ptxid,
                        "ptxid" => $tokenRaw->ptxid,
                        "bal"   => $member->credit,
                        "cur"   => "IDR",
                        "dup"   => false,
                        "err"   => 600,
                        "errdesc" => "transaction does not exist"
                    ]);        
                }else{
                    $betCreate = BetModel::create([
                        'bet_id' => $tokenRaw->ptxid,
                        'refptxid' => $tokenRaw->refptxid,
                        'win' => $tokenRaw->amt,
                        'platform' => $tokenRaw->gpcode,
                        'game_id' => $tokenRaw->gamecode,
                        'game' => $tokenRaw->gamename,
                        'game_info' => $tokenRaw->gametype == 0 ? 'slot' : 'TableGame',
                        'type' => $tokenRaw->txtype === 500 ? 'Bet' : ($tokenRaw->txtype === 510  ? 'Win' : ($tokenRaw->txtype === 511  ? 'Jackpot' : ($tokenRaw->txtype === 520 ? 'Lose' : ($tokenRaw->txtype === 530 ? 'Freebet' : ($tokenRaw->txtype === 540 ? 'Tie' : ($tokenRaw->txtype === 560 ? 'Cancel' : 'End_round')))))),
                        'round_id' => $tokenRaw->roundid,
                        'deskripsi' => $tokenRaw->txtype === 500 ? 'Game Bet' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 510  ? 'Game Win' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 511  ? 'Game Jackpot' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 520 ? 'Game Lose' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 530 ? 'Game Freebet' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 540 ? 'Game Tie' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 560 ? 'Cancel' : 'End_round')))))),
                        'created_at' => $tokenRaw->timestamp,
                        'created_by' => $tokenRaw->userid,
                        'constant_provider_id' => 9,
                    ]);

                    // update credit 
                    $balance = $member->credit + $tokenRaw->amt;
                    $member->update([
                        'credit' => $balance
                    ]);
                    
                    $transaction = array_push($data, [
                        "txid"  => $betCreate->id,
                        "ptxid" => $tokenRaw->ptxid,
                        "bal"   => $member->credit,
                        "cur"   => "IDR",
                        "dup"   => false
                    ]);
                }
            }
            return response()->json([
                'transactions' => $data
            ]);
        }
    }
}
