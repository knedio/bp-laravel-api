<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\UserDetail;
use Faker\Generator as Faker;

$factory->define(UserDetail::class, function (Faker $faker) {
    return [
        'firstName'    => $faker->firstName,
        // 'middleName'   => $faker->middleName,
        'lastName'     => $faker->lastName,
    ];
});
