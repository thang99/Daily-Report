<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Division;
use Faker\Generator as Faker;

$factory->define(Division::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' => config('common.status_division.active'),
    ];
});
