<?php

namespace App\Http\Resources\Api\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class PaitoResource extends JsonResource
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
            'id' => $this->id,
            'pasaran' => $this->pasaran,
            'jadwal' => $this->schedules->first()->open_time,
            'schedules' => $this->schedules,
            'result' => $this->resultNumber()->select(['id', 'constant_provider_togel_id', 'number_result_3', 'number_result_4', 'number_result_5', 'number_result_6', 'result_date'])->limit(8)->get(),
        ];
    }
}
