<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageContentResource extends JsonResource
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
        return [
            'type' => $this->type,
            'path' => $this->photo_path,
            'alt' => $this->alt,
            'order' => $this->order,
            'content' => $this->content,
        ];
    }
}
