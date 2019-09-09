<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OptionGroup;
use Faker\Generator as Faker;

$factory->define(OptionGroup::class, function (Faker $faker) {
    return [
        'name_group' => $faker->sentence(3),
        'options' => $faker->words(5)
    ];
});