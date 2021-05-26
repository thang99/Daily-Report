<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Position;
use Faker\Generator as Faker;
use App\Models\Division;

$factory->define(Position::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' => config('common.status_position.active')
    ];
});
