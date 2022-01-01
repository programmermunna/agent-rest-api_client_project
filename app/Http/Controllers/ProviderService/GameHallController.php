<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use App\Models\MembersModel;
use App\Models\BetModel;
use App\Models\UserLogModel;
use Carbon\Carbon;

class GameHallController extends Controller
{
	// Token From Casino Provider
	protected string $token;

	// ratio for slot
	protected int $ratio = 1000;

	// this As Object From Token Decoded
	protected object $transaction;

	protected string $betTime;

	// Before this Controller is called, we need to check if the user is logged in
	public function __construct()
	{

		$this->token =  request()->token;
		$this->transaction = JWT::decode($this->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
	}

	// Listen Transaction From Decoded Token
	public function listenTransaction()
	{
		$action = $this->transaction->action;

		switch ($action) {
			case 'bet':
				return $this->Bet();
				break;

			case 'settle':
				return $this->Settle();
				break;

			case 'betNSettle':
				return $this->BetNSettle();
				break;

			case 'cancelBetNSettle':
				return $this->CancelBetNSettle();
				break;

			case 'freeSpin':
				return $this->FreeSpin();
				break;

			case 'unsettle':
				return $this->UnSettle();
				break;

			case 'cancelBet':
				return $this->CancelBet();
				break;

			case 'adjustBet':
				return $this->AdjustBet();
				break;

			case 'adjustBet':
				return $this->AdjustBet();
				break;

			case 'voidBet':
				return $this->VoidBet();
				break;

			case 'voidSettle':
				return $this->VoidSettle();
				break;

			case 'unvoidSettle':
				return $this->UnVoidSettle();
				break;

			case 'refund':
				return $this->RefunBet();
				break;

			case 'unvoidBet':
				return $this->UnVoidBet();
				break;

			case 'tip':
				return $this->Tip();
				break;

			case 'give':
				return $this->Give();
				break;
		}
		return response()->json([
			'status' => 'error',
			'message' => 'Action not found'
		]);
	}


	public function Bet()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$member =  MembersModel::where('id', $tokenRaw->userId)->first();
			$amountbet = $tokenRaw->betAmount;
			$creditMember = $member->credit;
			$amount = $creditMember - $amountbet;
			$this->betTime = $tokenRaw->betTime;
			if ($creditMember < $amountbet) {
				return response()->json([
					"status" => '1018',
					"balance" => $creditMember,
					"balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")

				]);
			} else {
				// check if bet already exist
				$bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
				if ($bets) {
					return [
						"status" => '1025',
						"balance" => $creditMember,
						"balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
					];
				} else {
					// update credit to table member
					$member->update([
						'credit' => $amount,
						'updated_at' => $tokenRaw->betTime,
					]);
					$bets = BetModel::create([
						'platform'  => $tokenRaw->platform,
						'created_by' => $tokenRaw->userId,
						'updated_by' => $tokenRaw->userId,
						'bet_id' => $tokenRaw->platformTxId,
						'game_info' => 'live_casino',
						'game_id' => $tokenRaw->gameCode,
						'round_id' => $tokenRaw->roundId,
						'type' => 'Bet',
						'game' => $tokenRaw->gameName,
						'bet' => $amountbet,
						'created_at' => $tokenRaw->betTime,
						'constant_provider_id' => 7,
						'deskripsi' => 'Game Bet/Lose' . ' : ' . $amountbet,
					]);

					$nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
						->leftJoin('members', 'members.id', '=', 'bets.created_by')
						->where('bets.id', $bets->id)->first();
					$member =  MembersModel::where('id', $bets->created_by)->first();

					UserLogModel::logMemberActivity(
						'create bet',
						$member,
						$bets,
						[
							'target' => $nameProvider->username,
							'activity' => 'Bet',
							'device' => $nameProvider->device,
							'ip' => $nameProvider->last_login_ip,
						],
						"$nameProvider->username . ' Bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bets->game_info . ' idr '. $nameProvider->bet"
					);

					BetModel::where('game_id', $tokenRaw->gameCode)->first();
				}
			}
		}
		return [
			"status" => '0000',
			"balance" => $amount,
			"balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
		];
	}

	// Get the information of the user
	protected function betInformation()
	{
		$data = $this->transaction;
		return (object)[
			"data" => $data,
		];
	}

	public function CancelBet()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$member =  MembersModel::where('id', $tokenRaw->userId)->first();
			$creditMember = $member->credit;
			BetModel::query()->where('bet_id', '=', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->update([
					'type' => 'Cancel'
				]);
		}
		return [
			"status" => '0000',
			"balance" => $creditMember,
			"balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
		];
	}

	public function VoidBet()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$amountbet = $tokenRaw->betAmount;
			$bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->first();
			if ($bets == null) {
				return [
					"status" => '0000',
				];
			} else {
				$bets->update([
					'type' => 'Void',
					'bet' => $amountbet * $tokenRaw->gameInfo->odds,
					'updated_at' => $tokenRaw->updateTime,
				]);
			}
		}
		return [
			"status" => '0000',
		];
	}


	public function AdjustBet()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$member =  MembersModel::where('id', $tokenRaw->userId)->first();
			$creditMember = $member->credit;
			$amountbet = $tokenRaw->betAmount;
			$bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->first();

			if ($bets == null) {
				return [
					"status" => '0000',
				];
			} else {
				$bets->update([
					'bet' => $amountbet * $tokenRaw->gameInfo->odds,
					'updated_at' => $tokenRaw->updateTime,
				]);
			}
		}
		return [
			"status" => '0000',
			"balance" => $creditMember,
			"balanceTs"   => now()
		];
	}

	public function UnVoidBet()
	{
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->first();
			if ($bets == null) {
				return [
					"status" => '0000',
				];
			} else {
				$bets->update([
					'type' => 'Bet',
					'updated_at' => $tokenRaw->updateTime,
				]);
			}
		}
		return [
			"status" => '0000',
		];
	}

	public function RefunBet()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$bets = BetModel::where('bet_id', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->first();

			$member =  MembersModel::where('id', $tokenRaw->userId)->first();

			if ($bets == null) {
				return [
					"status" => '0000',
					"balance" => $member->credit,
					"balanceTs"   => now()
				];
			} else {

				$amountWin = $tokenRaw->winAmount;
				$amountBet = $tokenRaw->betAmount;
				$creditMember = $member->credit;

				// calculate balance member
				$amount = $creditMember + $amountBet - $amountWin;

				// update credit to table member
				$member->update([
					'credit' => $amount,
				]);

				$bets->update([
					'type' => 'Refund',
					'created_at' => $tokenRaw->betTime,
					'updated_at' => $tokenRaw->updateTime,
					'deskripsi' => 'Game Refund',
				]);
			}
		}
		return [
			"status" => '0000',
			"balance" => $amount,
			"balanceTs"   => now()
		];
	}

	public function Settle()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {

			$bets = BetModel::where('bet_id', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->where('type', 'Bet')
				->first();

			$member =  MembersModel::where('id', $tokenRaw->userId)->first();
			if ($bets == null) {
				return [
					"status" => '0000',
					"balance" => $member->credit,
					"balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
				];
			} else {

				$amountWin = $tokenRaw->winAmount;
				$creditMember = $member->credit;
				$amount = $creditMember + $amountWin;
				// update credit to table member
				$member->update([
					'credit' => $amount,
					'updated_at' => $tokenRaw->betTime,
				]);

				// check win / lose
				if ($tokenRaw->winAmount == 0) {
					$bets->update([
						'type' => 'Settle',
						'created_at' => $tokenRaw->betTime,
						'updated_at' => $tokenRaw->updateTime,
						'deskripsi' => 'Game Bet/Lose' . ' : ' . $tokenRaw->betAmount,
					]);
				} else {
					$bets->update([
						'type' => 'Settle',
						'win' => $amountWin,
						'created_at' => $tokenRaw->betTime,
						'updated_at' => $tokenRaw->updateTime,
						'deskripsi' => 'Game win' . ' : ' . $amountWin,
					]);
				}
			}
		}
		return [
			"status" => '0000',
			"balance" => $amount,
			"balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
		];
	}

	public function UnSettle()
	{
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$amountbet = $tokenRaw->betAmount;
			$member =  MembersModel::where('id', $tokenRaw->userId)->first();
			$member->update([
				'credit' => $member->credit + $tokenRaw->betAmount
			]);
			$bets = BetModel::query()
				->where('platform', $tokenRaw->platform)
				->where('bet_id', $tokenRaw->platformTxId)->first();
			if ($bets == null) {
				return [
					"status" => '1025',
				];
			} else {
				$bets->update([
					'type' => 'Bet',
					'bet' => $amountbet * $tokenRaw->gameInfo->odds,
					'updated_at' => $tokenRaw->updateTime,
				]);
			}
		}
		return [
			"status" => '0000',
		];
	}

	public function VoidSettle()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$amountbet = $tokenRaw->betAmount;
			$bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->first();
			if ($bets == null) {
				return [
					"status" => '0000',
				];
			} else {
				$bets->update([
					'type' => 'Void',
					'bet' => $amountbet * $tokenRaw->gameInfo->odds,
					'updated_at' => $tokenRaw->updateTime,
				]);
			}
		}
		return [
			"status" => '0000',
		];
	}

	public function UnVoidSettle()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->first();
			if ($bets == null) {
				return [
					"status" => '0000',
				];
			} else {
				$bets->update([
					'type' => 'Bet',
					'updated_at' => $tokenRaw->updateTime,
				]);
			}
		}
		return [
			"status" => '0000',
		];
	}

	public function Give()
	{
		// @todo Need Changes or Waiting For UAT
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$member =  MembersModel::where('id', $tokenRaw->userId)->first();
			$bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->first();

			$nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
				->leftJoin('members', 'members.id', '=', 'bets.created_by')
				->where('bets.id', $bets->id)->first();

			if ($bets == null) {
				return [
					"status" => '0000',
				];
			} else {
				$bonusAmount = $tokenRaw->amount;
				$creditMember = $member->credit;
				$amount = $creditMember + $bonusAmount;
				$member->update([
					'credit' => $amount,
					'updated_at' => now()->format("Y-m-d\TH:i:s.vP"),
				]);

				UserLogModel::logMemberActivity(
					'Member Bonus',
					$member,
					$bets,
					[
						'target' => $nameProvider->username,
						'activity' => 'Credit Bonus',
						'device' => $nameProvider->device,
						'ip' => $nameProvider->last_login_ip,
					],
					"$nameProvider->username Received Bonus On $nameProvider->constant_provider_name . ' type ' .  $bets->game_info . ' idr '. $nameProvider->bet"
				);
			}
		}
		return [
			"status" => '0000',
		];
	}

	public function Tip()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$tipAmount = $tokenRaw->tip;
			$member =  MembersModel::where('id', $tokenRaw->userId)->first();
			$creditMember = $member->credit;
			$amount = $creditMember - $tipAmount;
			// update credit to table member
			$member->update([
				'credit' => $amount,
				'updated_at' => now()->format("Y-m-d\TH:i:s.vP"),
			]);
		}
		return [
			"status" => '0000',
			"balance" => $creditMember ?? 0.0,
			"balanceTs" => now()->format("Y-m-d\TH:i:s.vP")
		];
	}

	public function CancelTip()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$tipAmount = $tokenRaw->tip;
			$member =  MembersModel::where('id', $tokenRaw->userId)->first();
			$creditMember = $member->credit;
			$amount = $creditMember + $tipAmount;
			$member->update([
				'credit' => $amount,
				'updated_at' => now()->format("Y-m-d\TH:i:s.vP"),
			]);
		}
		// For $creditMember will be Call on last index of loop and return again
		return [
			"status" => '0000',
			"desc" => 'succes',
			"balance" => $creditMember,
			"balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
		];
	}

	// slot and fish
	public function BetNSettle()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$member =  MembersModel::where('id', $tokenRaw->userId)->first();
			$amountbet = $tokenRaw->betAmount * 1000;
			$creditMember = $member->credit;
			$win = $tokenRaw->winAmount * 1000;
			$amount = $creditMember - $amountbet + $win;
			$this->betTime = $tokenRaw->betTime;
			if ($amount < 0) {
				return response()->json([
					"status" => '0000',
					"balance" => $creditMember / $this->ratio,
					"balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
				]);
			} else {
				// check if bet already exist
				$bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();
				if ($bets) {
					return [
						"status" => '0000',
						"balance" => $creditMember / $this->ratio,
						"balanceTs"   => $this->betTime
					];
				} else {
					// update credit to table member
					$member->update([
						'credit' => $amount,
						'created_at' => $tokenRaw->betTime,
						'updated_at' => $tokenRaw->updateTime,
					]);
					$bets = BetModel::create([
						'platform'  => $tokenRaw->platform,
						'created_by' => $tokenRaw->userId,
						'updated_by' => $tokenRaw->userId,
						'bet_id' => $tokenRaw->platformTxId,
						'game_info' => $tokenRaw->gameType == 'SLOT' ? 'slot' : 'fish',
						'game_id' => $tokenRaw->gameCode,
						'round_id' => $tokenRaw->roundId,
						'type' => 'Settle',
						'game' => $tokenRaw->gameName,
						'bet' => $amountbet,
						'win' => $tokenRaw->winAmount * 1000,
						'created_at' => $tokenRaw->betTime,
						'constant_provider_id' => 7,
						'deskripsi' => $tokenRaw->winAmount == 0 ? 'Game Bet/Lose' . ' : ' . $tokenRaw->winAmount : 'Game Win' . ' : ' . $tokenRaw->winAmount,
					]);

					$nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
						->leftJoin('members', 'members.id', '=', 'bets.created_by')
						->where('bets.id', $bets->id)->first();
					$member =  MembersModel::where('id', $bets->created_by)->first();

					UserLogModel::logMemberActivity(
						'create bet',
						$member,
						$bets,
						[
							'target' => $nameProvider->username,
							'activity' => 'Bet',
							'device' => $nameProvider->device,
							'ip' => $nameProvider->last_login_ip,
						],
						"$nameProvider->username . ' Bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bets->game_info . ' idr '. $nameProvider->bet"
					);

					BetModel::where('game_id', $tokenRaw->gameCode)->first();
				}
			}
		}
		return [
			"status" => '0000',
			"balance" => $amount / $this->ratio,
			"balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
		];
	}
	public function CancelBetNSettle()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$member =  MembersModel::where('id', $tokenRaw->userId)->first();
			$bet    = BetModel::query();

			$winBet = $bet->where('bet_id', '=', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)->first();


			// Prevent if bet already deducted 
			if ($winBet->type === 'Cancel' || empty($winBet) || isNull($winBet)) {
				return [
					"status" => '0000',
					"balance" => $member->credit / $this->ratio,
					"balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
				];
			}

			$amountbet = $tokenRaw->betAmount - ($winBet->win / $this->ratio);
			$creditMember = $member->credit;
			$amount = $creditMember + ($amountbet * $this->ratio);
			$member->update([
				'credit' => $amount,
				'created_at' => $tokenRaw->updateTime,
				'updated_at' => $tokenRaw->updateTime,
			]);
			$bet->where('bet_id', '=', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->update([
					'type' => 'Cancel'
				]);
		}
		return [
			"status" => '0000',
			"balance" => $member->credit / $this->ratio,
			"balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
		];
	}
	public function FreeSpin()
	{
		// call betInformation
		$token = $this->betInformation();
		foreach ($token->data->txns as $tokenRaw) {
			$bets = BetModel::where('bet_id', $tokenRaw->platformTxId)
				->where('platform', $tokenRaw->platform)
				->first();
			if ($bets == null) {
				return [
					"status" => '9999',
					"desc" => 'bet is not exists'
				];
			} else {

				$member =  MembersModel::where('id', $tokenRaw->userId)->first();
				$creditMember = $member->credit;
				$freeSpin = $tokenRaw->winAmount * 1000;
				$amount = $creditMember + $freeSpinwin;

				// update credit to table member
				$member->update([
					'credit' => $amount,
					'updated_at' => $tokenRaw->updateTime,
				]);

				// get free spin
				$bets->update([
					'win' => $freeSpin,
					'updated_at' => $tokenRaw->updateTime,
					'deskripsi' => 'Free Spin' . ' : ' . $freeSpin,
				]);
			}
		}
		return [
			"status" => '0000',
			"balance" => $member->credit / $this->ratio,
			"balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
		];
	}
}
