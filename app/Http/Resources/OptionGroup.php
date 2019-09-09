<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionGroup extends JsonResource
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
                'option_group_id' => $this->id,
                'name_group' => $this->name_group,
                'options' => $this->options,
            ],
            'links' => [
                'self' => $this->path(),
            ],
        ];
    }
}
