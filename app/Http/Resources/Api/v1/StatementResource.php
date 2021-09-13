<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class StatementResource extends JsonResource
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
            'id' => $this['id'],
            'description' => $this['withdraw'],
            'withdraw' => $this['withdraw'],
            'deposit' => $this['deposit'],
            'date' => $this['date'],
        ];
    }
}