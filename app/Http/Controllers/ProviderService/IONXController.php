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
            $bet = BetModel::create([
                'bet_id' => $this->token->RefNo,
                'bet' => $this->token->Stake,
                'seq_no' => $this->token->SeqNo,
                'guid' => $this->token->Guid,
                'created_at' => $this->token->Timestamp,
                'constant_provider_id' => 8,
                'created_by' => $this->memberId
            ]);
            
            $member->update([
                'credit' => $balance,
                'updated_at' => $this->token->Timestamp,
            ]);
        }

        return response()->json([
            'Result' => "SUCCESS",
            'OrderId' => $bet->id,
        ]);
    }

    public function getPlayerBalance()
    {
        $this->checkTokenIsValid();

        $credit = MembersModel::find($this->memberId)->credit;

        return response()->json([
            'AvailableCredit' => $credit,
            'Result' => "SUCCESS",
        ]);
    }

    public function rollbackPlayerBalance()
    {
        $this->checkTokenIsValid();
        
        $bet = BetModel::where('id', '=', $this->token->OrderId)
                        ->where('ref_no', '=', $this->token->RefNo)
                        ->first();
        if ($bet) {
            //rollback bet
            $bet->delete();

            // rollback credit
            $member = MembersModel::find($this->memberId);
            $balance = $member->credit + $this->token->Stake;    

            return response()->json([
                'Result' => "SUCCESS",
                'Amount' => $balance,
            ]);
        }else{
            return response()->json([
                'Result' => "ORDER_NOT_FOUND",
            ]);
        }
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
            $bet = BetModel::where('id', '=', $this->token->OrderId)
                    ->first();
            if ($bet) {
                $bet->update([
                    'bet_id' => $this->token->RefNo,
                    'created_by' => $this->token->AccountId,
                    'bet' => $this->token->Stake,
                    'game_id' => $this->token->GameId,
                    'game' => $this->token->ProductType,
                    'round_id' => $this->token->OrderId,
                    'created_at' => $this->token->Timestamp,
                    'constant_provider_id' => 8,
                    'type' => 'Bet',
                    'deskripsi' => 'Game Bet' . ' : ' . $this->token->Stake,
                    'created_by' => $this->memberId
                ]);
            }else{
                // Insert/Update Running Bet
                BetModel::create([
                    'bet_id' => $this->token->RefNo,
                    'created_by' => $this->token->AccountId,
                    'bet' => $this->token->Stake,
                    'game_id' => $this->token->GameId,
                    'game' => $this->token->ProductType,
                    'round_id' => $this->token->OrderId,
                    'created_at' => $this->token->Timestamp,
                    'constant_provider_id' => 8,
                    'type' => 'Bet',
                    'deskripsi' => 'Game Bet' . ' : ' . $this->token->Stake,
                    'created_by' => $this->memberId
                ]);

                $member->update([
                    'credit' => $balance
                ]);
            }
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
