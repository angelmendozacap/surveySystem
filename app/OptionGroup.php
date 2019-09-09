<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionGroup extends Model
{
    protected $guarded = [];

    protected $casts = [
        'options' => 'array'
    ];

    public function path()
    {
        return url('/option-groups/'.$this->id);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
