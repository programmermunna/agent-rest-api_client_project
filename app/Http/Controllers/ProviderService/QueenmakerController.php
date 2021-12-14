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
        // dd($token);
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
                    'type' => $tokenRaw->gametype == 0 ? 'slot' : 'TableGame',
                    'round_id' => $tokenRaw->roundid,
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
}
