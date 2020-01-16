<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyUser extends JsonResource
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
                'survey_id' => $this->id,
                'survey_name' => $this->name,
                'description' => $this->description,
                'status' => $this->status,
                'created_at' => $this->created_at->diffForHumans(),
            ],
            'links' => [
                'self' => '/surveys-to-answer/' . $this->id
            ],
        ];
    }
}
