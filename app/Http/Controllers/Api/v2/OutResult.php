<?php

namespace App\Http\Controllers\Api\v2;

use App\Helpers\History;
use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\v2\OutResultResource;
use App\Http\Resources\Api\v2\PaitoResource;
use App\Models\ConstantProviderTogelModel;
use App\Models\TogelResultNumberModel;
use App\Traits\CustomPaginate;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\WithPagination;

/**
 * @author Hanan Asyrawi Rivai 
 */
class OutResult extends ApiController
{

	use WithPagination;
  public $perPage = 10;
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
	public function getAllPasaran()
	{

		$results = ConstantProviderTogelModel::select([
								'id',
								'name_initial as nama_id',
								'name as pasaran',
								'website_url as web',
								'hari_diundi as hari_undi',
								'libur as libur',
								'tutup as tutup',
								'jadwal as jadwal',
								'period as periode',
								'status as is_active'
							])
							->with('resultNumber')
							->orderBy('id', 'asc')
							->get();
		return OutResultResource::collection($results);
	}

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

	public function paitoEight()
	{
		$paito = ConstantProviderTogelModel::query()
			->select([
				'id',
				'name_initial as nama_id',
				'name as pasaran',
				'website_url as web',
				'hari_diundi as hari_undi',
				'libur as libur',
				'tutup as tutup',
				'jadwal as jadwal',
				'period as periode',
				'status as is_active',
			])
			->with('resultNumber')
			->get();
			
		return PaitoResource::collection($paito);
		
	}

	public function paitoAll(Request $request)
	{
		try {
			$paitos = ConstantProviderTogelModel::query()
							->select([
								'id',
								'name_initial as nama_id',
								'name as pasaran',
								'website_url as web',
								'hari_diundi as hari_undi',
								'libur as libur',
								'tutup as tutup',
								'jadwal as jadwal',
								'period as periode',
								'status as is_active',
							]);
			$paito = $paitos->first();
			$checkPasaran = $paitos->where('id', $request->pasaran)->first();
			$resultNumber = TogelResultNumberModel::leftJoin('constant_provider_togel as a', 'a.id', '=', 'togel_results_number.constant_provider_togel_id')
											->selectRaw("
												togel_results_number.id,
												concat(number_result_3, number_result_4, number_result_5, number_result_6) as resultNumber,
												togel_results_number.period,
												togel_results_number.result_date,
												if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Monday'
													, 'Senin'
													, if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Tuesday'
														, 'Selasa'
														, if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Wednesday'
															, 'Rabu'
															, if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Thursday'
																, 'Kamis'
																, if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Friday'
																	, 'Jum`at'
																	, if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Saturday'
																		, 'Sabtu'
																		, 'Minggu'
																	)
																)
															)
														)
													)
												) as day,
												concat(a.name_initial, '-', togel_results_number.period) as pasaran
											")
											->orderBy('togel_results_number.result_date', 'desc');
			if ($checkPasaran) {				
				$result = $resultNumber->where('togel_results_number.constant_provider_togel_id', $request->pasaran);
				$data = [
					'id'      		=> $checkPasaran->id,
					'pasaran' 		=> $checkPasaran->pasaran,
					'initial' 		=> $checkPasaran->nama_id,
					'hari_undi'   => $checkPasaran->hari_undi,
					'libur'   		=> $checkPasaran->libur,
					'url'     		=> $checkPasaran->web,
					'tutup'   		=> $checkPasaran->tutup,
					'jadwal'  		=> $checkPasaran->jadwal,
					'periode' 		=> $checkPasaran->periode,
					'is_active'   => $checkPasaran->is_active,
					'result'  		=> $this->paginate($result->get()->toArray(), $this->perPage)
				];
				return $this->successResponse($data, null, 200);
			} else {								
				$result = $resultNumber->where('togel_results_number.constant_provider_togel_id', $paito->id);
				$data = [
					'id'      		=> $paito->id,
					'pasaran' 		=> $paito->pasaran,
					'initial' 		=> $paito->nama_id,
					'hari_undi'   => $paito->hari_undi,
					'libur'   		=> $paito->libur,
					'url'     		=> $paito->web,
					'tutup'   		=> $paito->tutup,
					'jadwal'  		=> $paito->jadwal,
					'periode' 		=> $paito->periode,
					'is_active'   => $paito->is_active,
					'result'  		=> $this->paginate($result->get()->toArray(), $this->perPage)
				];
				$message = $request->pasaran == null ? null : 'Pasaran Not Found';
				return $this->successResponse($data, $message, 200);
			}
		} catch (\Throwable $th) {
			return $this->errorResponse("Server Internal Error", 500);
		}				
	}

	# just test
	public function paitoTestAll(Request $request)
	{
		try {
			$paitos = ConstantProviderTogelModel::query()
							->select([
								'id',
								'name_initial as nama_id',
								'name as pasaran',
								'website_url as web',
								'hari_diundi as hari_undi',
								'libur as libur',
								'tutup as tutup',
								'jadwal as jadwal',
								'period as periode',
								'status as is_active',
							]);
			$checkPasaran = $paitos->where('id', $request->pasaran)->first();
			if ($checkPasaran == null) {
				return $this->errorResponse("Pasaran not Found", 200);
			}
			$resultNumber = TogelResultNumberModel::leftJoin('constant_provider_togel as a', 'a.id', '=', 'togel_results_number.constant_provider_togel_id')
											->selectRaw("
												togel_results_number.id,
												concat(number_result_3, number_result_4, number_result_5, number_result_6) as resultNumber,
												togel_results_number.period,
												togel_results_number.result_date,
												if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Monday'
													, 'Senin'
													, if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Tuesday'
														, 'Selasa'
														, if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Wednesday'
															, 'Rabu'
															, if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Thursday'
																, 'Kamis'
																, if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Friday'
																	, 'Jum`at'
																	, if(DATE_FORMAT(togel_results_number.result_date, '%W') = 'Saturday'
																		, 'Sabtu'
																		, 'Minggu'
																	)
																)
															)
														)
													)
												) as day,
												concat(a.name_initial, '-', togel_results_number.period) as pasaran
											")
											->orderBy('togel_results_number.result_date', 'desc');
						
				$result = $resultNumber->where('togel_results_number.constant_provider_togel_id', $request->pasaran);
				$data = [
					'id'      		=> $checkPasaran->id,
					'pasaran' 		=> $checkPasaran->pasaran,
					'initial' 		=> $checkPasaran->nama_id,
					'hari_undi'   => $checkPasaran->hari_undi,
					'libur'   		=> $checkPasaran->libur,
					'url'     		=> $checkPasaran->web,
					'tutup'   		=> $checkPasaran->tutup,
					'jadwal'  		=> $checkPasaran->jadwal,
					'periode' 		=> $checkPasaran->periode,
					'is_active'   => $checkPasaran->is_active,
					'result'  		=> $this->paginate($result->get()->toArray(), $this->perPage)
				];
				return $this->successResponse($data, null, 200);
		} catch (\Throwable $th) {
			return $this->errorResponse("Server Internal Error", 500);
		}				
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
								group by a.id
								order by b.id"
							);

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

	// pagination
  public function paginate($items, $perPage, $page = null, $options = [])
  {
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);

    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
  }

}
