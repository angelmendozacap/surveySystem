<?php

namespace App\Http\Resources;

use App\Http\Resources\QuestionsAnswers;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyQuestions extends JsonResource
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
                'questions' => QuestionsAnswers::collection($this->questions)
            ],
        ];
    }
}
