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

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function inputType()
    {
        return $this->belongsTo(InputType::class);
    }
}
