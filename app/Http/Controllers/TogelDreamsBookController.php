<?php

namespace App\Http\Controllers;

use App\Models\TogelDreamsBookModel;
use App\Traits\CustomPaginate;
use Illuminate\Http\Request;

class TogelDreamsBookController extends Controller
{
	use CustomPaginate;

	public function getDreamsBook(Request $request)
	{

		$searchTerm =  $request->search;

		if (isset($searchTerm)) {

			$status = TogelDreamsBookModel::select([
				'togel_dreams_book.name', 'togel_dreams_book.combination_number'
			])
				->where('togel_dreams_book.name', 'like', "%$searchTerm%")
				->get();

			return $this->paginate($status, 10);
		}

		$status = TogelDreamsBookModel::select([
			'togel_dreams_book.name', 'togel_dreams_book.combination_number'
		])
			->whereIn('togel_dreams_book.type', ['2D', '3D', '4D'])
			->get();

		return $this->paginate($status, 15);
	}	
}
