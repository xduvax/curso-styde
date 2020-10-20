<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserProfile;
use Faker\Generator as Faker;

$factory->define(UserProfile::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\Models\User')->create()->id,
        'twitter' => $faker->url,
        'bio' => $faker->paragraph(3, false)
    ];
});
