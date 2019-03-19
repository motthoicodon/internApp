<?php

use Faker\Generator as Faker;
use App\Member;

$factory->define(App\Member::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'information' => $faker->text($maxNbChars = 300),
        'phone' => $faker->e164PhoneNumber,
        'birthday' => $faker->date($format = 'Y-m-d', $max = '-10 years'),
        'avatar' => $faker->imageUrl($width = 640, $height = 480),
        'position' => Member::POSITIONS[array_rand(Member::POSITIONS)],
        'gender' => Member::GENDERS[array_rand(Member::GENDERS)],
    ];
});
