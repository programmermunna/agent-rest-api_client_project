<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembersModel;
use App\Models\BetModel;
use Firebase\JWT\JWT;

class QueenmakerController extends Controller
{
    public function getDebitQueenMaker()
    {
        $token =  JWT::decode(request()->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        // check if any token
        if (!$token && is_null($token)) {
            return response()->json([ 
                "err" => 10,
                "errdesc" => "Token has expired"
            ]);
        }else{
            foreach ($token->transactions as $tokenRaw) {
                // create transaction on debit
                $bet = BetModel::create([
                    'bet_id' => $tokenRaw->ptxid,
                    'refptxid' => $tokenRaw->refptxid,
                    'bet' => $tokenRaw->amt,
                    'platform' => $tokenRaw->gpcode,
                    'game_id' => $tokenRaw->gamecode,
                    'game' => $tokenRaw->gamename,
                    'game_info' => $tokenRaw->gametype == 0 ? 'slot' : 'TableGame',
                    'type' => $tokenRaw->txtype === 500 ? 'Bet' : ($tokenRaw->txtype === 510  ? 'Win' : ($tokenRaw->txtype === 511  ? 'Jackpot' : ($tokenRaw->txtype === 520 ? 'Lose' : ($tokenRaw->txtype === 530 ? 'Freebet' : ($tokenRaw->txtype === 540 ? 'Tie' : 'End_round'))))),
                    'round_id' => $tokenRaw->roundid,
                    'deskripsi' => $tokenRaw->txtype === 500 ? 'Game Bet' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 510  ? 'Game Win' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 511  ? 'Game Jackpot' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 520 ? 'Game Lose' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 530 ? 'Game Freebet' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 540 ? 'Game Tie' . ' : ' . $tokenRaw->amt : 'End_round'))))),
                    'created_at' => $tokenRaw->timestamp,
                    'created_by' => $tokenRaw->userid,
                ]);
                // get credit
                $member = MembersModel::find($tokenRaw->userid);
                // calculate balance
                $balance = $member->credit - $tokenRaw->amt;
                $member->update([
                    'credit' => $balance
                ]);
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
        $token =  JWT::decode(request()->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        // check if any token
        if (!$token && is_null($token)) {
            return response()->json([ 
                "err" => 10,
                "errdesc" => "Token has expired"
            ]);
        }else{
            foreach ($token->transactions as $tokenRaw) {
                // create transaction on debit
                $bet = BetModel::create([
                    'bet_id' => $tokenRaw->ptxid,
                    'refptxid' => $tokenRaw->refptxid,
                    'win' => $tokenRaw->amt,
                    'platform' => $tokenRaw->gpcode,
                    'game_id' => $tokenRaw->gamecode,
                    'game' => $tokenRaw->gamename,
                    'game_info' => $tokenRaw->gametype == 0 ? 'slot' : 'TableGame',
                    'type' => $tokenRaw->txtype === 500 ? 'Bet' : ($tokenRaw->txtype === 510  ? 'Win' : ($tokenRaw->txtype === 511  ? 'Jackpot' : ($tokenRaw->txtype === 520 ? 'Lose' : ($tokenRaw->txtype === 530 ? 'Freebet' : ($tokenRaw->txtype === 540 ? 'Tie' : 'End_round'))))),
                    'deskripsi' => $tokenRaw->txtype === 500 ? 'Game Bet' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 510  ? 'Game Win' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 511  ? 'Game Jackpot' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 520 ? 'Game Lose' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 530 ? 'Game Freebet' . ' : ' . $tokenRaw->amt : ($tokenRaw->txtype === 540 ? 'Game Tie' . ' : ' . $tokenRaw->amt : 'End_round'))))),
                    'created_by' => $tokenRaw->userid,
                    'created_at' => $tokenRaw->timestamp,
                    'updated_at' => $tokenRaw->timestamp,
                ]);
                // get credit
                $member = MembersModel::find($tokenRaw->userid);
                // calculate balance
                $balance = $member->credit + $tokenRaw->amt;
                $member->update([
                    'credit' => $balance
                ]);
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
}
