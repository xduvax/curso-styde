<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Skill;

$factory->define(Skill::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2, false)
    ];
});
