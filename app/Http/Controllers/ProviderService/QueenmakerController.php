<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use App\Models\MembersModel;
use App\Models\BetModel;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class QueenmakerController extends Controller
{
	public $data = [];

	public function getDebitQueenMaker()
	{
		$token =  JWT::decode(request()->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
		// check if any token
		if (!$token && is_null($token)) {
			return response()->json([
				"err" => 10,
				"errdesc" => "Invalid or expired token"
			]);
		} else {
			foreach ($token->transactions as $tokenRaw) {
				$member = MembersModel::find($tokenRaw->userid);
				// calculate balance
				$balance = $member->credit - $tokenRaw->amt;
				if ($balance < 0) {
					return response()->json([
						"err" => 100,
						"errdesc" => "Insufficient funds to perform the operation"
					]);
				} else {
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

	// Persist To Database
	public function getCreditQueenMaker()
	{
		$token =  JWT::decode(request()->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
		// Bet Model Persisting The Credit / OR Settle the placement Bet
		$betModel = BetModel::query();
		// Return Error Response 
		$errorResponse = response()->json([
			"err" => 10,
			"errdesc" => "Token has expired"
		]);
		// check the token is exist or expired 
		if (!$token && is_null($token)) {
			return $errorResponse;
		}
		foreach ($token->transactions as $tokenRaw) {
			$transactionStatus = $tokenRaw->txtype;
			$member = MembersModel::find($tokenRaw->userid);
			// Check the transactionStatus please see the token your send
			// on field txtype
			switch ($transactionStatus) {
				case '560':
					$this->cancelBet($member, $tokenRaw);
					break;
				default:
					$this->settleBet($member, $tokenRaw);
					break;
			}
		}
		return response()->json([
			'transactions' => $this->data,
		]);
	}

	/**
	 * @param MembersModel $member
	 * @param object $tokenRaw
	 * Check if member balance has deduct we need revert the balance 
	 * and check the bet if some bet not exist on database 
	 * adding new Response for bet 
	 * and return to multiple transactionStatus
	 * @author Hanan asyrawi Rivai
	 */
	protected function cancelBet(MembersModel $member, $tokenRaw)
	{
		$bet = DB::table('bets')->where('bet_id', '=', $tokenRaw->refptxid)->first();
		if (is_null($bet)) {
			array_push($this->data, [
				'txid' => $tokenRaw->ptxid,
				'ptxid' => $tokenRaw->ptxid,
				'bal' => (int)$member->credit,
				'cur' => 'IDR',
				'dup' => false,
				"error" => 600,
				"errordesc" => "transaction does not exist"
			]);
			return;
		}
		$memberCredit = $member->credit + $tokenRaw->amt;
		$member->update([
			'credit' => $memberCredit
		]);
		array_push($this->data, [
			'txid' => $bet->id,
			'ptxid' => $bet->bet_id,
			'bal' => $member->credit,
			'cur' => 'IDR',
			'dup' => false,
		]);
	}
	/**
	 * @param MembersModel $member
	 * @param object $tokenRaw
	 * settle the bet and checked is win or not with prevent 
	 * the balance of member has deducted or not
	 * @author Hanan asyrawi Rivai
	 */
	protected function settleBet(MembersModel $member, $tokenRaw)
	{
		// first check on we end the bet has already exist or not
		$bet = DB::table('bets')->where('bet_id', '=', $tokenRaw->ptxid)->first();
		// if exist adding to response and do nothing or not deduct balance
		if ($bet) {
			// Adding To Response with dup == true 
			// this mean the bet exist on database
			array_push($this->data, [
				'txid' => $tokenRaw->ptxid,
				'ptxid' => $tokenRaw->ptxid,
				'bal' => (int)$member->credit,
				'cur' => 'IDR',
				'dup' => true,
			]);
			return;
		}

		$memberCredit = $member->credit + $tokenRaw->amt;

		$member->update([
			'credit' => $memberCredit
		]);

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
		array_push($this->data, [
			'txid' => $betCreate->id,
			'ptxid' => $tokenRaw->ptxid,
			'bal' => (int)$member->credit,
			'cur' => 'IDR',
			'dup' => false,
		]);
		return;
	}
}
