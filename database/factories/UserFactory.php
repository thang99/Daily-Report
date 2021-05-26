<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use App\Models\PositionDivision;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'position_division_id' => null,
        'avatar' => 'default-avatar.png',
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make(1234567),
        'phone' => $faker->numberBetween(00000000000, 9999999999),
        'birthday' => $faker->date(),
        'status' => config('common.status_user.active'),
        'remember_token' => Str::random(10),
    ];
});
