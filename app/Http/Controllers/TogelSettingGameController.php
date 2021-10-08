<?php

namespace App\Http\Controllers;

use App\Models\TogelSettingGames;
use Illuminate\Http\Request;

class TogelSettingGameController extends ApiController 
{
	public function getTogelSettingGame(Request $request)
	{
		switch ($request->type) {
			case 'normal':
				return TogelSettingGames::query()->normal([1,2,3,4], 1)->get();	
				break;
			case 'colok':
				return TogelSettingGames::query()->colokjitu([5,6,7,8,9], 1)->get();
				break;
			case '50:50':
				return TogelSettingGames::query()->fifty([9,10,11], 1)->get();
				break;
			case 'lain-lain':
				return TogelSettingGames::query()->colokjitu([12 , 13, 14], 1)->get();
				break;
			default:
				return response('Missing Type');	
				break;
		}
	}	
}
