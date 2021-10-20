<?php

namespace App\Http\Controllers;

use App\Models\ConstantProviderTogelModel;
use App\Models\TogelGame;
use App\Models\TogelSettingGames;
use Illuminate\Http\Request;

class TogelSettingGameController extends ApiController 
{
	public function getTogelSettingGame(Request $request)
	{
		$request->validate(['provider' => 'required|numeric']); 
    
		switch ($request->type) {
			case 'normal':
				return TogelSettingGames::query()->normal([1,2,3,4], $request->provider)->get();	
				break;
			case 'colok':
				return TogelSettingGames::query()->colokjitu([5,6,7,8,9], $request->provider)->get();
				break;
			case '50:50':
				return TogelSettingGames::query()->fifty([9,10,11], $request->provider)->get();
				break;
			case 'lain-lain':
				return TogelSettingGames::query()->colokjitu([12 , 13, 14], $request->provider)->get();
				break;
			default:
				return response('Missing Type');	
				break;
		}
	}

    /**
	 * Get Global Setting Games 
	 */	
	public function getGlobalSettingGame(Request $request)
	{
		$provider = $request->provider;		

		if(!isset($provider) && empty($provider)) {
			return response()->json([
				'code' => 422,
				'message' => 'Hmm provider and type of game must exist on params'
			]);	
		}

		$settingGames = TogelSettingGames::query()
			->addSelect([
					'togel_game' => TogelGame::select('name')->whereColumn('togel_game.id', 'togel_setting_game.togel_game_id')])
			->whereHas('constant_provider_togel', function ($value) use ($provider) {
				$value
					->where('name', $provider);
			})
			->latest()
			->orderBy('id' , 'desc')
			->get();

		return $settingGames;

	}	
}
