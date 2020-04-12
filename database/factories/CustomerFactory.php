<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    $faker->locale('ru_RU');
    return [
        'name'  => $faker->name,
        'phone' => $faker->PhoneNumber,
        'description' => $faker->realText(rand(400, 500)), 
        'files_link' => $faker->imageUrl(800,600),
    ];
});
