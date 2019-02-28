<?php

use Faker\Generator as Faker;
use App\Model\Member;
use App\Model\WorksOn;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Model\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->text($maxNbChars = 10),
        'information' => $faker->text($maxNbChars = 300),
        'deadline' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'type' => App\Model\Project::TYPES[array_rand(App\Model\Project::TYPES)],
        'status' => App\Model\Project::STATUS[array_rand(App\Model\Project::STATUS)],
    ];
});

$factory->define(Member::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'information' => $faker->text($maxNbChars = 300),
        'phone' => $faker->e164PhoneNumber,
        'birthday' => $faker->date($format = 'Y-m-d', $max = '-10 years'),
        'avartar' => $faker->imageUrl($width = 640, $height = 480),
        'position' => Member::POSITIONS[array_rand(Member::POSITIONS)],
        'gender' => Member::GENDER[array_rand(Member::GENDER)],
    ];
});

$factory->define(WorksOn::class, function (Faker $faker) {

    $project = \App\Model\Project::get()->random();
    $member = Member::get()->random();

    return [
        'member_id' => $member->id,
        'project_id' => $project->id,
        'role' => WorksOn::ROLES[array_rand(WorksOn::ROLES)],
    ];
});
