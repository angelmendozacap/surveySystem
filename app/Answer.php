<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'answers_array' => 'array'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}