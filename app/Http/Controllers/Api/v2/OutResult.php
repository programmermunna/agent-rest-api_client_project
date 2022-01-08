<?php

namespace App\Http\Controllers\Api\v2;

use App\Helpers\History;
use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\v2\OutResultResource;
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
	use CustomPaginate, History;

	/**
	 * Get all Togel Result Number 
	 * @return JsonResponse 
	 */
	public function getAllResult()
	{

		$results = TogelResultNumberModel::join('constant_provider_togel', 'togel_results_number.constant_provider_togel_id', '=', 'constant_provider_togel.id')
		->selectRaw("
                date_format(cast(togel_results_number.result_date as date), '%d %M %Y') as 'tanggal'
                , DAYNAME(CAST(togel_results_number.result_date AS DATE)) as 'hari'
                , concat(constant_provider_togel.name_initial, '-' , togel_results_number.period) as 'pasaran'
                , concat(
                    cast(togel_results_number.number_result_1 as char(2))
                    , cast(togel_results_number.number_result_2 as char(2))
                    , cast(togel_results_number.number_result_3 as char(2))
                    , cast(togel_results_number.number_result_4 as char(2))
                    , cast(togel_results_number.number_result_5 as char(2))
                    , cast(togel_results_number.number_result_6 as char(2))
                ) as 'result'
            ")->get();

		return $this->paginate($results, 10); 
	}
	/**
	 * Get Pasaran Blok Angka
	 * @return LengthAwarePaginator 
	 */
	public function getPasaran()
	{

		$results = ConstantProviderTogelModel::select([
			'constant_provider_togel.id',
			'constant_provider_togel.name_initial as nama_id',
			'constant_provider_togel.name as pasaran',
			'constant_provider_togel.website_url as web',
			'constant_provider_togel.hari_diundi as hari_undi',
			'constant_provider_togel.libur as libur',
			'constant_provider_togel.tutup as tutup',
			'constant_provider_togel.jadwal as jadwal',
		])
		  ->where('status' , true)
		  ->with('resultNumber')
	  	  ->orderByDesc('id')
		  ->get()
	  	  ->toArray();
		return $this->paginate($results , 20);
	}

	public function getResultByProvider()
	{
		$provider = ConstantProviderTogelModel::query()
			->select([
				'constant_provider_togel.id',
				'constant_provider_togel.name_initial as nama_id',
				'constant_provider_togel.name as pasaran',
				'constant_provider_togel.website_url as web',
				'constant_provider_togel.hari_diundi as hari_undi',
				'constant_provider_togel.libur as libur',
				'constant_provider_togel.tutup as tutup',
				'constant_provider_togel.jadwal as jadwal',
				'constant_provider_togel.period as periode',
				'constant_provider_togel.status as is_active',
			])
			->where('status' , true)
			->orWhere('auto_online', 1)
			->with('resultNumber')
			->get();

		return OutResultResource::collection($provider);
	}

	public function getShioTables() 
	{
		$result = DB::select("select
								a.id as id ,
								a.name as 'shio'
								, group_concat(b.numbers) as 'numbers'
								from
								togel_shio_name a
								join togel_shio_number b on a.id = b.togel_shio_name_id
								group by a.id;");

		return response()->json([
			'status' => 'success',
			'code'   => 200,
			'data'   => $result
		]);
	}

	public function getDetailTransaksi()
	{
		$params = request()->get('detail');
		$id = explode(",", $params);
		return $this->get()
			->whereIn('bets_togel.id', $id)
			->get();
	}

}
