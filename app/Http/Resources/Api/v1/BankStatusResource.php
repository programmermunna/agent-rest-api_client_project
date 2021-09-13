<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BankStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->status == 1) {
            $status = 'on';
        } elseif ($this->status == 2) {
            $status = 'off';
        } else {
            $status = 'gg';
        }

        return [
            'name' => $this->name,
            'status' => $status,
            'filename' => Str::lower($this->name),
            // 'image' => $this->logo_path,
            // 'base64_image' => $this->base64_path,
        ];
    }
}
