<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BetsTogelRequest;
use App\Models\ConstantProviderTogelModel;
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

		// get setting games 
		$settingGames = $this->getSettingGames($gameType , $provider)->first()->id;

		$bets = [];
		// Loop the validated data and take key data and remapping the key
		foreach ($request->validationData()['data'] as $togel) {
			array_push($bets, array_merge($togel, [
				"togel_game_id" => $gameType,
				"constant_provider_togel_id" => $provider,
				'togel_setting_game_id' => $settingGames,
				'created_by' => auth('api')->user()->id, // Laravel Can Handler which user has login please cek config.auth folder
			]));
		}

		try {
			DB::table('bets_togel')->insert($bets);
			return response()->json(['message' => 'success', 'code' => 200], 200);
		} catch (Throwable $error) {
			DB::rollBack();
			Log::error($error->getMessage());
			return $error->getMessage(); 
		}

	}

	// Check if exist on request 
	protected function checkType() : void
	{
		if (!isset(request()->type) || empty(request()->type)) {
			throw new NewException("type is empty please fill", 400);
		}else if (!isset(request()->provider) || empty(request()->provider)) {
			throw new NewException("Provider Cannot  empty please fill", 400);
		}
	}

	// Persistance to Database
	protected function InsertTheBets(array $bets) 
	{
		try {
			DB::beginTransaction();
			DB::table('bets_togel')->insert($bets);
			DB::commit();
			return true;
		} catch (Throwable $error) {
			DB::rollBack();
			Log::error($error->getMessage());
			return false; 
		}
	}

	protected function getSettingGames(int $gameType, int $gameProvider) : Builder
	{
		$result = TogelSettingGames::query()
					->where('constant_provider_togel_id' ,'=' , $gameProvider)
					->where('togel_game_id' , '=' , $gameType);

		return $result;
	}
}
