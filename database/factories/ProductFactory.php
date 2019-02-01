<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'price' => $faker->randomDigitNotNull,
        'stock' => $faker->numberBetween(1,100),
        'stock_unit_type' => $faker->randomElement(array('Kg','g','unit')),
    ];
});