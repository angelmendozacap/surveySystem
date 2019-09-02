<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InputType extends Model
{
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}