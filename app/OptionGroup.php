<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionGroup extends Model
{
    protected $guarded = [];

    protected $casts = [
        'options' => 'array'
    ];
}
