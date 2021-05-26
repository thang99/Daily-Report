<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Follow;
use Faker\Generator as Faker;
use App\Models\User;

$factory->define(Follow::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'by' => User::all()->random()->id,
        'status' => config('common.status_follow.on_follow'),
    ];
});
