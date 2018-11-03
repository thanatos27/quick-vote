<?php

use Faker\Generator as Faker;

$factory->define(App\Questionnaire::class, function (Faker $faker) {
    return [
        'title'         => $faker->text(50),
        'description'   => $faker->text(50),
        'choice_1'      => $faker->text(20),
        'choice_2'      => $faker->text(20)
    ];
});
