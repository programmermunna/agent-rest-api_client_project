<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use App\Models\BetModel;
use App\Models\MembersModel;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IONXController extends Controller
{
    private $token;
    private $memberId;
    /**
     * @var object
     */
    private $transaction;

    public function __construct()
    {
        //some init here
        $this->token = JWT::decode(request()->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));

        // for filter the player id player19 to 19(only take number)
        $this->memberId = (int) filter_var($this->token->AccountId, FILTER_SANITIZE_NUMBER_INT);
    }

    public function deductPlayerBalance()
    {
        $member = MembersModel::find($this->memberId);
        $balance = $member->credit - $this->token->Stake;
        if ($balance < 0) {
            return response()->json([ 
                "Result" => "INSUFFICIENT_BALANCE",
                "Description" => "Insufficient balance for deduction"
            ]);
        }else{
            $member->update([
                'credit' => $balance,
                'updated_at' => $this->token->TimeStamp,
            ]);
        }

        return response()->json([
            'Result' => "SUCCESS",
            'OrderId' => $memberId,
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
        $member = MembersModel::find($this->memberId);
        // calculate balance
        $balance = $member->credit - $this->token->Stake;
        if ($balance < 0) {
            return response()->json([ 
                "Result" => "GENERAL_ERROR"
            ]);
        }else{
            // Insert/Update Running Bet
            $bet = BetModel::create([
                'bet_id' => $this->token->RefNo,
                'created_by' => $this->token->AccountId,
                'bet' => $this->token->Stake,
                'game_id' => $this->token->GameId,
                'game' => $this->token->ProductType,
                'round_id' => $this->token->OrderId,
                'created_at' => $this->token->OrderTime,
                'constant_provider_id' => 8,
                'type' => 'Bet',
                'deskripsi' => 'Game Bet' . ' : ' . $this->token->Stake
            ]);

            $member->update([
                'credit' => $balance,
                'last_login_ip' => $this->token->Ip
            ]);
        }
        return response()->json([ 
            'Result' => "SUCCESS",
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
