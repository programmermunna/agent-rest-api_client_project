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
        
        $bets = BetModel::where('id', '=', $this->token->OrderId)
                        ->where('bet_id', '=', $this->token->RefNo)
                        ->where('seq_no', '=', $this->token->SeqNo)
                        ->first();
        $member = MembersModel::find($this->memberId);
        $balance = $member->credit + $bets->bet;    

        return response()->json([
            'Result' => "SUCCESS",
            'Amount' => $balance,
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
            $bet = BetModel::where('bet_id', '=', $this->token->RefNo)
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

    public function SettleBet()
    {
        $this->checkTokenIsValid();
        $member = MembersModel::find($this->memberId);
        if (!$member) {
            return response()->json([ 
                "Result" => "MEMBER_NOT_FOUND"
            ]);
        }else{
            $balance = $member->credit + $this->token->PlayerWinLoss;
            BetModel::create([
                'bet_id' => $this->token->RefNo,
                'win' => $this->token->PlayerWinLoss,
                'bet' => $this->token->Stake,
                'player_wl' => $this->token->WinningStake,
                'bet_option' => $this->token->BetOptions,
                'group_bet_option' => $this->token->GroupBetOptions,
                'constant_provider_id' => 8,
                'type' => $this->token->SettlementStatus === "WON" ? "Win" : ($this->token->SettlementStatus === "LOSE"  ? "Bet" : "Cancel"),
                'deskripsi' => $this->token->SettlementStatus === "WON" ? "Game Win " . " : " . $this->token->PlayerWinLoss : ($this->token->SettlementStatus === "LOSE"  ? "Game Lose " . " : " . $this->token->Stake : "Game Cancel " . ":" . $this->token->PlayerWinLoss),
                'created_at' => $this->token->SettleTime,
                'created_by' => $this->memberId,
                'guid' => $this->token->Guid
            ]);

            $member->update([
                'credit' => $balance,
                'updated_at' => $this->token->SettleTime
            ]);
        }
        return response()->json([ 
            'Result' => "SUCCESS",
        ]);
    }

    public function ResultGame()
    {
        $this->checkTokenIsValid();
        $bet = BetModel::where('game_id', '=', $this->token->GameId)
                ->first();
        if ($bet) {
            // If GameId already exists, the existing data will be overwrite
            $bet->update([
                'game' => $this->token->ProductType,
                'shoe_id' => $this->token->ShoeID,
                'game_status' => $this->token->GameStatus,
                'constant_provider_id' => 8,
                'type' => $this->token->Result === "WON" ? "Win" : ($this->token->Result === "LOSE"  ? "Bet" : ($this->token->Result === "VOID" ? "Void" : ($this->token->Result === "DRAW" ? "Tie" : "Cancel"))),
                'created_at' => $this->token->Timestamp,
            ]);
        }else{
            // Insert game result for statement and bet history
            BetModel::create([
                'game_id' => $this->token->GameId,
                'game' => $this->token->ProductType,
                'shoe_id' => $this->token->ShoeID,
                'game_status' => $this->token->GameStatus,
                'guid' => $this->token->Guid,
                'constant_provider_id' => 8,
                'type' => $this->token->Result === "WON" ? "Win" : ($this->token->Result === "LOSE"  ? "Bet" : ($this->token->Result === "VOID" ? "Void" : ($this->token->Result === "DRAW" ? "Tie" : "Cancel"))),
                'created_at' => $this->token->Timestamp,
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
