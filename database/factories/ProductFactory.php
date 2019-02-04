<?php

use Faker\Generator as Faker;
use Cknow\Money\Money as Money;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'price' => Money::EUR($faker->randomFloat(2, 2, 6) * 100),
        'stock' => $faker->numberBetween(1,100),
        'stock_unit_type' => $faker->randomElement(array('Kg','g','unit')),
    ];
});