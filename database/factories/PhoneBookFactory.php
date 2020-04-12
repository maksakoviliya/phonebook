<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PhoneBook;
use Faker\Generator as Faker;

$factory->define(PhoneBook::class, function (Faker $faker) {
  $faker->locale = 'ru_RU';  
  return [
    'parent_id'   => 0,
    'title'       => $faker->sentence(rand(3,5), true),
    'full_name'   => $faker->sentence(rand(8,10), true),
    'description' => $faker->realText(rand(400, 500)), 
    'contacts'    => [],
  ];
});
