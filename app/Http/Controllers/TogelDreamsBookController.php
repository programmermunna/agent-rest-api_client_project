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
		$types = $request->type;
		if (isset($searchTerm)) {
			$status = TogelDreamsBookModel::select([
				'togel_dreams_book.name', 'togel_dreams_book.combination_number',
				'togel_dreams_book.type'
			])
				->where('togel_dreams_book.name', 'like', "%$searchTerm%")
				->get();
			return $this->paginate($status, 10);
		} else if(isset($types)){
			
			$status = TogelDreamsBookModel::select([
				'togel_dreams_book.name', 'togel_dreams_book.combination_number',
				'togel_dreams_book.type'
			])
				->where('togel_dreams_book.name', 'like', "%$searchTerm%")
				->where('type' , '=' , $types)
				->get();
			return $this->paginate($status, 10);
		}
		$status = TogelDreamsBookModel::select([
			'togel_dreams_book.name', 'togel_dreams_book.combination_number',
			'togel_dreams_book.type'
		])
			->whereIn('togel_dreams_book.type', ['2D', '3D', '4D'])
			->get();
		return $this->paginate($status, 15);
	}	
}
