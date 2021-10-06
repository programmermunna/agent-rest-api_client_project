<?php

namespace App\Http\Resources\Api\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class OutResultResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'id'     => $this->id,
			'pasaran' => $this->pasaran,
			'initial' => $this->nama_id,
			'hari_undi' => $this->hari_undi,
			'libur'   => $this->libur,
			'url'     => $this->web,
			'tutup'   => $this->tutup,
			'jadwal'  => $this->jadwal,
			'periode' => $this->periode,
			'result'  => $this->resultNumber()->orderByDesc('result_date')->first(),
		];
	}
}