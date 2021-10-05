<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\ApiController;
use App\Models\ConstantProviderTogelModel;
use App\Models\TogelResultNumberModel;
use App\Traits\CustomPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
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

		return $this->paginate($result, 25);
	}	
	/**
	 * Get Pasaran Blok Angka
	 * @return LengthAwarePaginator 
	 */
	public function getPasaran() : LengthAwarePaginator
	{
	  $results = ConstantProviderTogelModel::select([
             'constant_provider_togel.name_initial as Nama ID',
             'constant_provider_togel.name as Nama Pasaran',
             'constant_provider_togel.website_url as Web',
             'constant_provider_togel.hari_diundi as Hari di Undi',
             'constant_provider_togel.libur as Libur',
             'constant_provider_togel.tutup as Tutup',
             'constant_provider_togel.jadwal as Jadwal',
        ])->get();

	   return $this->paginate($results , 20);
	}

	public function getResultByProvider()
	{
		$provider = ConstantProviderTogelModel::query()->with(['resultNumber' => function ($res) {
			$res->whereBetween('result_date', [now()->startOfWeek(), now()->endOfWeek()]);
		}])
			->get()
			->toArray();
		return $this->paginate($provider, 20);
	}
}
