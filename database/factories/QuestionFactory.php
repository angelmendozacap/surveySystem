<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Survey;
use App\Question;
use App\InputType;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'survey_id' => factory(Survey::class),
        'name' => $faker->sentence(),
        'subtext' => $faker->text(),
        'is_required' => false,
        'input_type_id' => factory(InputType::class)
    ];
});
