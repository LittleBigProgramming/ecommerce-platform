<?php

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'slug' => str_slug($name),
        'description' => $faker->sentence(rand(5, 10)),
        'price' => rand(2.5, 100)
    ];
});