<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class MemoResource extends JsonResource
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
            'subject' => $this['subject'],
            'content' => $this['content'],
            'received_at' => $this['received_at'],
            'is_read' => $this['is_read'],
        ];
    }
}