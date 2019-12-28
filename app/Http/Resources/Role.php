<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
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
            'data' => [
                'role_id' => $this->id,
                'name' => $this->name,
                'created_at' => $this->created_at->diffForHumans(),
            ],
            'links' => [
                'self' => url('/roles/'.$this->id),
            ],
        ];
    }
}
