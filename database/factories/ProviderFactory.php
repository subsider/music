<?php

use App\Models\Provider\Provider;
use Faker\Generator as Faker;

$factory->define(Provider::class, function (Faker $faker) {
    return [
        'name' => rtrim($faker->sentence(2), '.'),
    ];
});
