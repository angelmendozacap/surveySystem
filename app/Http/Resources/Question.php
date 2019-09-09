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
            'question_id' => $this->id,
            'name' => $this->name,
            'subtext' => $this->subtext,
            'survey_id' => $this->survey_id,
            'is_required' => $this->is_required,
            'input_type' => $this->inputType->name,
            'option_group' => $this->optionGroup->name_group ?? $this->option_group_id
        ];
    }
}