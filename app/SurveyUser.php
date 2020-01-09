<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyUser extends Model
{
    protected $guarded = [];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
