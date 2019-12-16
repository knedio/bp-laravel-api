<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserDetail;
use Faker\Generator as Faker;

$factory->define(UserDetail::class, function (Faker $faker) {
    return [
        'first_name'    => $faker->firstName,
        // 'middle_name'   => $faker->middleName,
        'last_name'     => $faker->lastName,
    ];
});
