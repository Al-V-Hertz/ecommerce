<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'item_image' => "images/mysterybox.jpg",
        'item_name' =>  Str::random(10),
        'item_desc' => Str::random(20),
        'item_stock' => 50,
        'item_price' => 150.50,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
