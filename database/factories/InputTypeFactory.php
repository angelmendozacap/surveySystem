<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InputType;
use Faker\Generator as Faker;

$factory->define(InputType::class, function (Faker $faker) {
    return [
        'type' => $faker->word,
        'display_name' => $faker->word,
    ];
});
