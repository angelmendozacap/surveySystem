<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use App\Survey;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'survey_id' => factory(Survey::class),
        'name' => $faker->sentence(),
        'subtext' => $faker->text(),
        'is_required' => false,
        'input_type_id' => $faker->word,
    ];
});
