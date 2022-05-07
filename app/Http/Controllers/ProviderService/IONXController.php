<?php

namespace App\Http\Controllers\ProviderService;

use App\Domains\Announcement\Models\Announcement;
use App\Http\Controllers\Controller;
use App\Models\BetModel;
use App\Models\MembersModel;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IONXController extends Controller
{

	// Token from cika_slot_api_provider
    private $token;
	// Member id 

    private $memberId;
    /**
     * @var object
     */

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
                'game_info' => 'live_casino',
                'seq_no' => $this->token->SeqNo,
                'guid' => $this->token->Guid,
                'created_at' => Carbon::now(),
                'credit' => $balance,
                'deskripsi' => 'Deduct player balance',
                // 'created_at' => $this->token->Timestamp,
                'constant_provider_id' => 8,
                'created_by' => $this->memberId
            ]);

            $member->update([
                'credit' => $balance,
                'updated_at' => Carbon::now(),
                // 'updated_at' => $this->token->Timestamp,
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
                    'game_info' => 'live_casino',
                    'game_id' => $this->token->GameId,
                    'game' => $this->token->ProductType,
                    'round_id' => $this->token->OrderId,
                    'created_at' => Carbon::now(),
                    // 'created_at' => $this->token->Timestamp,
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
                    'game_info' => 'live_casino',
                    'game_id' => $this->token->GameId,
                    'game' => $this->token->ProductType,
                    'round_id' => $this->token->OrderId,
                    'created_at' => Carbon::now(),
                    'credit' => $balance,
                    // 'created_at' => $this->token->Timestamp,
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

		$bet = BetModel::query();
		$settleStatus = $this->token->SettlementStatus ?? "";

        if (!$member) {
            return response()->json([
                "Result" => "MEMBER_NOT_FOUND"
            ]);
        }else{

			// Calculate The Member the Balance
            $balance = $member->credit + $this->token->PlayerWinLoss;
			// UDAH PATENT BOSS KU JANGAN DI RUBAH
			if($settleStatus === "VOID"){
				$refundBet = ($this->token->PlayerWinLoss - $this->token->Stake );
				$refundBalance = $member->credit - $refundBet;
				BetModel::create([
					'bet_id' => $this->token->RefNo,
					'win' => $this->token->PlayerWinLoss,
					// 'bet' => $this->token->Stake,
					'player_wl' => $this->token->WinningStake,
                    'game_info' => 'live_casino',
					'bet_option' => $this->token->BetOptions,
					'group_bet_option' => $this->token->GroupBetOptions,
					'constant_provider_id' => 8,
					'type' => 'VOID', 
					'deskripsi' => "Refund Balance " . $refundBet, 
					'created_at' => Carbon::now(),
                    'credit' => $refundBalance,
					// 'created_at' => $this->token->SettleTime,
					'created_by' => $this->memberId,
					'guid' => $this->token->Guid
				]);
				$member->update([
					'credit' => $refundBalance,
					'updated_at' => $this->token->SettleTime
				]);
				return response()->json([
					'Result' => "SUCCESS",
				]);
			}

            BetModel::create([
                'bet_id' => $this->token->RefNo,
                'win' => $this->token->PlayerWinLoss,
                // 'bet' => $this->token->Stake,
                'player_wl' => $this->token->WinningStake,
                'bet_option' => $this->token->BetOptions,
                'group_bet_option' => $this->token->GroupBetOptions,
                'constant_provider_id' => 8,
                'game_info' => 'live_casino',
                'type' => $this->token->SettlementStatus === "WON" ? "Win" : ($this->token->SettlementStatus === "LOSE"  ? "Lose" : "Cancel"),
                'deskripsi' => $this->token->SettlementStatus === "WON" ? "Game Win " . " : " . $this->token->PlayerWinLoss : ($this->token->SettlementStatus === "LOSE"  ? "Game Lose " . " : " . $this->token->Stake : "Game Cancel " . ":" . $this->token->PlayerWinLoss),
                'created_at' => Carbon::now(),
                'credit' => $balance,
                // 'created_at' => $this->token->SettleTime,
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

    public function insertGameAnnouncement()
    {
        $this->checkTokenIsValid();
        try {
            $data = [
                'area' => 'frontend',
                'message' => $this->token->Id, //message in indonesian
                'enabled' => true,
                'starts_at' => $this->token->PostDate,
                'ends_at' => $this->token->PostDate,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_by' => 1,
                'updated_at' => Carbon::now(),
            ];

            Announcement::create($data);

            $result = [
                'Result' => "SUCCESS",
            ];
        } catch (\Exception $e) {
            Log::error($e);

            $result = [
                'Result' => "GENERAL_ERROR",
            ];
        }

        return response()->json($result);
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
