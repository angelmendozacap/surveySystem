<?php

namespace App\Http\Resources;

use App\Http\Resources\Role as RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
                'user_id' => $this->id,
                'role' => new RoleResource($this->role),
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => $this->created_at->diffForHumans(),
            ],
            'links' => [
                'self' => url('/users/'.$this->id),
            ],
        ];
    }
}
