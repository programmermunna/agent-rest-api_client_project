<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BetsTogelRequest;
use App\Models\BetsTogel;
use App\Models\ConstantProviderTogelModel;
use App\Models\TogelGame;
use App\Models\TogelResultNumberModel;
use App\Models\TogelSettingGames;
use Exception as NewException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BetsTogelController extends ApiController
{
	/**
	 * storingBetsTogel place the bet togels  
	 * @param BetsTogelRequest $request
	 */
	public function store(BetsTogelRequest $request)
	{
		// First For All Take The Type Of Game 
		$togelGames = TogelGame::query()->get()->pluck(['id'], 'name');
		$providerGame = ConstantProviderTogelModel::query()->get()->pluck(['id'], 'name');

		// Cek From Request or Body Has Value Type Of Games
		$this->checkType();
		// take type of game and provider
		$gameType = $togelGames[$request->type];
		$provider = $providerGame[$request->provider];

		$togel_result_number = TogelResultNumberModel::query()
			->where('constant_provider_togel_id', $provider)
			->latest('result_date')
			->first();


		// get setting games 
		$settingGames = $this->getSettingGames($gameType, $provider)->first();

		$bets = [];
		$total_bets_after_disc = [];
		// Loop the validated data and take key data and remapping the key
		foreach ($this->checkBlokedNumber($request, $provider) as $togel) {
			array_push($bets, array_merge($togel, [
				'period'  		=> empty($togel_result_number->period) ? 1 : intval($togel_result_number->period) + 1,
				"togel_game_id" => $gameType,
				"constant_provider_togel_id" => $provider,
				'togel_setting_game_id' => is_null($settingGames) ? null : $settingGames->id, // will be error if the foreign key not release 
				'created_by' => auth('api')->user()->id, // Laravel Can Handler which user has login please cek config.auth folder
				'created_at' => now()
			]));
			// Sum pay_amount
			array_push($total_bets_after_disc, floatval($togel['pay_amount']));
		}
		if (empty($bets)) {
			return response()->json([
				'code' => 422,
				'messages' => 'Data is empty Or number bloked first please add more number'
			], 422);
		}

		try {
			DB::beginTransaction();

			$idx = [];

			foreach ($bets as $bet) {
				$idx[] = DB::table('bets_togel')->insertGetId($bet);
			}
			/// will be convert to 1,2,3,4,5
			$bets_id  = implode(",", $idx);
			DB::select("CALL TriggerInsertAfterBetsTogel('" . $bets_id . "')"); // will be return empty
			DB::select("SET @bet_ids=' a.id in (" . $bets_id . ")';");
			$response = DB::select("CALL is_buangan_before_terpasang(@bet_ids)"); // will be return empty
			// Cek This is Bet Buangan 
			if ($response[0]->results != null) {
				foreach (json_decode($response[0]->results) as $bet) {
					BetsTogel::query()
						->where('id', $bet->bet_id)
						->where('constant_provider_togel_id', $bet->constant_provider_togel_id)
						->update([
							'is_bets_buangan' => $bet->is_bets_buangan,
							'buangan_before_submit' => $bet->buangan_before_submit,
						]);
				}
			}

			$this->updateCredit($total_bets_after_disc);
			ConstantProviderTogelModel::query()
				->where('id', '=', $provider)
				->update(['period' => $togel_result_number->period + 1]);
			DB::commit();
			return response()->json(['message' => 'success', 'code' => 200], 200);
		} catch (Throwable $error) {
			DB::rollBack();
			Log::error($error->getMessage());
			return $error->getMessage();
		}
	}

	// Check if exist on request 
	// @return void
	protected function checkType(): void
	{
		if (!isset(request()->type) || empty(request()->type)) {
			throw new NewException("type is empty please fill", 400);
		} else if (!isset(request()->provider) || empty(request()->provider)) {
			throw new NewException("Provider Cannot  empty please fill", 400);
		}
	}

	/**
	 * Get Setting Games 
	 * @param int $gameType
	 * @param int $gameProvider
	 * @return Builder
	 */
	protected function getSettingGames(int $gameType, int $gameProvider): Builder
	{
		$result = TogelSettingGames::query()
			->where('constant_provider_togel_id', '=', $gameProvider)
			->where('togel_game_id', '=', $gameType);

		return $result;
	}

	/**
	 * this will cek the bloked number 
	 * and return safe number after the we be marging the data 
	 * @param BetsTogelRequest $request
	 * @param array $number
	 */
	protected function checkBlokedNumber(BetsTogelRequest $request, int $provider)
	{
		$blokedsNumber = [];

		$stackNumber = ['number_1', 'number_2', 'number_3', 'number_4', 'number_5', 'number_6'];

		if (in_array($stackNumber, $request->validationData()['data'])) {
			foreach ($request->validationData()['data'] as $key => $data) {
				$number_1 = $data['number_1'] != null ? "number_1 = {$data['number_1']} and " : null;
				$number_2 = $data['number_2'] != null ? "number_2 = {$data['number_2']} and " : null;
				$number_3 = $data['number_3'] != null ? "number_3 = {$data['number_3']} and " : null;
				$number_4 = $data['number_4'] != null ? "number_4 = {$data['number_4']} and " : null;
				$number_5 = $data['number_5'] != null ? "number_5 = {$data['number_5']} and " : null;
				$number_6 = $data['number_6'] != null ? "number_6 = {$data['number_6']} and " : null;

				$query = $number_1 . $number_2 . $number_3 . $number_4 . $number_5 . $number_6 . "constant_provider_togel_id = " . $provider;
				$result = DB::select("CALL trigger_togeL_blok_angka_after_bets_togel('" . $query . "')");

				// Cek if result from bloked number is null is approved number
				if ($result[0]->nomor == null) {
					array_push($blokedsNumber, $request->validationData()['data'][$key]);
				}
			}

			return $blokedsNumber;
		}

		return $request->validationData()['data'];
	}

	/**
	 * update The Credit
	 * @param array $totalBets
	 */
	protected function updateCredit($totalBets)
	{

		if (auth('api')->user()->credit === 0) {
			return response()->json([
				'code' => 422,
				'message' => 'saldo kurang'
			], 422);
		}

		$credit = floatval(auth('api')->user()->credit) - array_sum($totalBets);
		auth('api')->user()->update([
			'credit' => $credit
		]);
	}
}
