<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ManagerDivision;
use App\Models\User;
use App\Models\Division;
use Faker\Generator as Faker;


$factory->define(ManagerDivision::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'division_id' => Division::all()->random()->id,
    ];
});
