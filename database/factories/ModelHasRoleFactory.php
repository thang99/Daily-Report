<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ModelHasRoles;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;
use App\Models\User;

$factory->define(ModelHasRoles::class, function (Faker $faker) {
    return [
        'role_id' => Role::all()->random()->id,
        'model_type' => 'App\Models\User',
        'model_id' => User::all()->random()->id,
    ];
});
