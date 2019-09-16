<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function setInputTypeIdAttribute($input_type)
    {
        $this->attributes['input_type_id'] = InputType::firstOrCreate([
            'name' => strtolower($input_type),
        ])->id;
    }

    public function getCodeNameInputAttribute()
    {
        return "s{$this->survey->id}_q{$this->id}";
    }

    // QueryScopes
    public function scopeCurrentSurveyQuestions($query, $survey_id)
    {
        return $query->where('survey_id', $survey_id);
    }

    // Relationships
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function inputType()
    {
        return $this->belongsTo(InputType::class);
    }

    public function optionGroup()
    {
        return $this->belongsTo(OptionGroup::class);
    }
}
