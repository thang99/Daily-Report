<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Report;
use Faker\Generator as Faker;
use App\Models\User;

$factory->define(Report::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'assign_to' => User::all()->random()->id,
        'title' => $faker->title,
        'content' => $faker->paragraph,
        'status' => config('common.status_report.waiting')
    ];
});
