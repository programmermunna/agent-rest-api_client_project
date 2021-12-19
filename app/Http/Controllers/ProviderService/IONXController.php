<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use App\Models\BetModel;
use App\Models\MembersModel;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class IONXController extends Controller
{
    private $token;
    /**
     * @var object
     */
    private $transaction;

    public function __construct()
    {
        //some init here
        $this->token = JWT::decode(request()->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
        //probably some other initializations here.
    }

    public function deductPlayerBalance()
    {
        $this->checkTokenIsValid();
        foreach ($this->transaction->data->txns as $tokenRaw) {
            $member = MembersModel::find($tokenRaw->AccountId);
            $balance = $member->credit - $tokenRaw->stake;

            if ($balance < 0) {
                return response()->json([ 
                    "Result" => "INSUFFICIENT_BALANCE",
                    "Description" => "Insufficient balance for deduction"
                ]);
            }else{
                $refNo = $tokenRaw->RefNo;
                $member->update([
                    'credit' => $balance,
                    'updated_at' => $tokenRaw->Timestamp,
                ]);
            }
        }

        return response()->json([
            'Result' => "SUCCESS",
            'OrderId' => $refNo ?? 0,
        ]);
    }

    public function getPlayerBalance()
    {
        $this->checkTokenIsValid();

        foreach ($this->transaction->data->txns as $tokenRaw) {
            $member = MembersModel::find($tokenRaw->AccountId);
            $balance = $member->credit;
        }

        return response()->json([
            'AvailableCredit' => $balance,
            'Result' => 200,
        ]);
    }

    public function rollbackPlayerBalance()
    {
        $this->checkTokenIsValid();

        foreach ($this->transaction->data->txns as $tokenRaw) {
            $member = MembersModel::find($tokenRaw->AccountId);
            $balance = $member->credit + $tokenRaw->Amount;

            $member->update([
                'credit' => $balance,
                'updated_at' => $tokenRaw->Timestamp,
            ]);

            BetModel::query()->where('bet_id', '=', $tokenRaw->platformTxId)
                ->where('platform', $tokenRaw->platform)
                ->update([
                    'type' => 'Cancel'
                ]);
        }

        return response()->json([
            'AvailableCredit' => $balance,
            'Result' => 200,
        ]);
    }

    public function InsertRunningBet()
    {
        $this->checkTokenIsValid();

        foreach ($this->transaction->data->txns as $tokenRaw) {
            $bet = BetModel::where('game_id', $tokenRaw->GameId)
                ->where('created_by', $tokenRaw->AccountId)
                ->where('id', $tokenRaw->OrderId)
                ->first();

            $bet->update([
                'bet' => $tokenRaw->Stake,
                'game_id' => $tokenRaw->GameId,
                'updated_at' => $tokenRaw->Timestamp
            ]);
        }

        return response()->json([
            'Result' => 201
        ]);
    }

    private function checkTokenIsValid()
    {
        if (!$this->token && is_null($this->token)) {
            return response()->json([
                "err" => 401,
                "errdesc" => "Token has expired"
            ]);
        }

        $this->transaction = (object) [
            "data" => $this->token,
        ];
    }
}
