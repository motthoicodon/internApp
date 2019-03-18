<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->text($maxNbChars = 10),
        'information' => $faker->text($maxNbChars = 300),
        'deadline' => "2020-{$faker->month}-{$faker->dayOfMonth}",
        'type' => App\Project::TYPES[array_rand(App\Project::TYPES)],
        'status' => App\Project::STATUS[array_rand(App\Project::STATUS)],
    ];
});
