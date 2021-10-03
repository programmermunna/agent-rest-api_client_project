<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\ApiController;
use App\Traits\CustomPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * @author Hanan Asyrawi Rivai 
 */
class OutResult extends ApiController
{
	use CustomPaginate;

	/**
	 * Get all Togel Result Number 
	 * @return JsonResponse 
	 */
	public function getAllResult() 
	{
		$result = DB::table('togel_results_number')
			->join("constant_provider_togel", 'togel_results_number.constant_provider_togel_id', '=', 'constant_provider_togel.id')
			->select([
				'constant_provider_togel.name',
				'constant_provider_togel.name_initial',
				'togel_results_number.period',
				'togel_results_number.result_date',
				'togel_results_number.number_result_1',
				'togel_results_number.number_result_2',
				'togel_results_number.number_result_3',
				'togel_results_number.number_result_4',
				'togel_results_number.number_result_4',
				'togel_results_number.number_result_5',
				'togel_results_number.number_result_6',
			])
				->latest('togel_results_number.created_at')
				->get();

		return $this->paginate($result , 25);
	}	
}
