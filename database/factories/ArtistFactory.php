<?php

use App\Models\Music\Artist;
use Faker\Generator as Faker;

$factory->define(Artist::class, function (Faker $faker) {
    return [
        'name' => rtrim($faker->sentence, '.'),
    ];
});
