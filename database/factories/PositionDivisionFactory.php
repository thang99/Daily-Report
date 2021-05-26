<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PositionDivision;
use Faker\Generator as Faker;
use App\Models\Division;
use App\Models\Position;

$factory->define(PositionDivision::class, function (Faker $faker) {
    return [
        'division_id' => Division::all()->random()->id,
        'position_id' =>Position::all()->random()->id,
    ];
});
