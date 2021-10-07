<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BetsTogelRequest;
use App\Models\ConstantProviderTogelModel;
use App\Models\TogelGame;
use Exception as NewException;
use Illuminate\Support\Facades\DB;
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
		$this->checkProvider();
		// take type of game and provider
		$gameType = $togelGames[$request->type];
		$provider = $providerGame[$request->provider];

		$bets = [];
		foreach ($request->validationData()['data'] as $togel) {
			array_push($bets, array_merge($togel, [
				"togel_game_id" => $gameType,
				"constant_provider_togel_id" => $provider,
			]));
		}

		$this->InsertTheBets($bets);

		return response()->json(['message' => 'success', 'code' => 200], 200);
	}

	protected function checkType()
	{
		if (!isset(request()->type) || empty(request()->type)) {
			throw new NewException("type is empty please fill", 400);
		}
	}

	protected function checkProvider()
	{
		if (!isset(request()->provider) || empty(request()->provider)) {
			throw new NewException("Provider Cannot  empty please fill", 400);
		}
	}

	protected function InsertTheBets(array $bets)
	{
		try {
			DB::beginTransaction();
			DB::table('bets_togel')->insert($bets);
			DB::commit();
		} catch (Throwable $error) {
			DB::rollBack();
			return response($error);
		}
	}
}
