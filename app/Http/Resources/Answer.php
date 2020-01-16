<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Answer extends JsonResource
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
                'answer_id' => $this->id,
                'answer' => $this->answer,
                'question' => new Question($this->question),
                'created_at' => $this->created_at->diffForHumans(),
                'updated_at' => $this->created_at->diffForHumans()
            ]
        ];
    }
}
