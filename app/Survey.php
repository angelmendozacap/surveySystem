<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($survey) {
            $survey->questions()->delete();
        });
    }

    public function path()
    {
        return '/surveys/' . $this->id;
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function surveysAnswered()
    {
        return $this->hasMany(SurveyUser::class);
    }
}
