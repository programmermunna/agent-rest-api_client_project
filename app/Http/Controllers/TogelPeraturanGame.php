<?php

namespace App\Http\Controllers;

use App\Models\WebSiteContent;
use Illuminate\Http\Request;

class TogelPeraturanGame extends ApiController 
{
	/**
	 * Get Peraturan Game
	 */
	public function getPeraturanGame(Request $request) 
	{
		$type = $request->type; 

		return  WebSiteContent::query()
			->select('title', 'slug', 'contents')
			->when(isset($type) && !empty($type), function ($value) use ($type) {
				return $value->where('slug', '=', $type);
			})
			->get();
	}
}
