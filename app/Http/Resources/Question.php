<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Question extends JsonResource
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
                'question_id' => $this->id,
                'survey_id' => $this->survey_id,
                'name' => $this->name,
                'code_name' => $this->code_name_input,
                'subtext' => $this->subtext,
                'is_required' => $this->is_required,
                'input_type' => new InputType($this->inputType)
            ]
        ];
    }
}
