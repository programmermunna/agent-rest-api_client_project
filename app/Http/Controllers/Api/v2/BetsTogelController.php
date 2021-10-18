<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BetsTogelRequest;
use App\Models\ConstantProviderTogelModel;
use App\Models\TogelBlokAngka;
use App\Models\TogelGame;
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
		
		$this->checkBlokedNumber($request , $provider);
		// get setting games 
		$settingGames = $this->getSettingGames($gameType , $provider)->first();
		
		$bets = [];
		// Loop the validated data and take key data and remapping the key
		foreach ($this->checkBlokedNumber($request , $provider) as $togel) {
			array_push($bets, array_merge($togel, [
				"togel_game_id" => $gameType,
				"constant_provider_togel_id" => $provider,
				'togel_setting_game_id' => is_null($settingGames) ? null : $settingGames->id, // will be error if the foreign key not release 
				'created_by' => auth('api')->user()->id, // Laravel Can Handler which user has login please cek config.auth folder
			]));
		}

		try {
			DB::beginTransaction();
			$idx = [];
			foreach ($bets as $bet) {
				$idx[] = DB::table('bets_togel')->insertGetId($bet);
			}
			/// will be convert to 1,2,3,4,5
			$bets_id  = implode(",", $idx);
			DB::select("CALL TriggerInsertAfterBetsTogel('" . $bets_id. "')"); // will be return empty
		    DB::select("CALL is_buangan_before_terpasang('" . $bets_id. "')"); // after bets run procedure to update buangan 

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
	protected function checkType() : void
	{
		if (!isset(request()->type) || empty(request()->type)) {
			throw new NewException("type is empty please fill", 400);
		}else if (!isset(request()->provider) || empty(request()->provider)) {
			throw new NewException("Provider Cannot  empty please fill", 400);
		}
	}

	/**
	 * Get Setting Games 
	 * @param int $gameType
	 * @param int $gameProvider
	 * @return Builder
	 */
	protected function getSettingGames(int $gameType, int $gameProvider) : Builder
	{
		$result = TogelSettingGames::query()
					->where('constant_provider_togel_id' ,'=' , $gameProvider)
					->where('togel_game_id' , '=' , $gameType);

		return $result;
	}

	/**
	 * this will cek the bloked number 
	 * and return safe number after the we be marging the data 
	 * @param BetsTogelRequest $request
	 * @param array $number
	 */
	protected function checkBlokedNumber(BetsTogelRequest $request , int $provider)
	{
		$blokedsNumber = [] ;
		foreach ($request->validationData()['data'] as $key => $data) {
			$number_1 = $data['number_1'] != null ? "number_1 = {$data['number_1']} and " : null;
			$number_2 = $data['number_2'] != null ? "number_2 = {$data['number_2']} and " : null;
			$number_3 = $data['number_3'] != null ? "number_3 = {$data['number_3']} and " : null;
			$number_4 = $data['number_4'] != null ? "number_4 = {$data['number_4']} and " : null;
			$number_5 = $data['number_5'] != null ? "number_5 = {$data['number_5']} and " : null;
			$number_6 = $data['number_6'] != null ? "number_6 = {$data['number_6']} and " : null;

			$query = $number_1 . $number_2 . $number_3 . $number_4 . $number_5 . $number_6 . "constant_provider_togel_id = " . $provider;
			$result = DB::select("CALL trigger_togeL_blok_angka_after_bets_togel('" . $query . "')");

			if($result[0]->nomor == null) {
				array_push($blokedsNumber , $request->validationData()['data'][$key]);
			}
		}
		return $blokedsNumber;
	}
}
