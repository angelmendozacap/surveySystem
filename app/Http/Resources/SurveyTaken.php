<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyTaken extends JsonResource
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
                'survey_taken_id' => $this->id,
                'user_id' => $this->user_id,
                'survey' => new SurveyUser($this->survey),
                'taken_at' => $this->created_at->diffForHumans(),
            ]
        ];
    }
}
