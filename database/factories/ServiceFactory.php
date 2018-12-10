<?php

use App\Models\Music\Artist;
use App\Models\Provider\Provider;
use App\Models\Provider\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    $model = factory(Artist::class)->create();
    return [
        'provider_id' => function () {
            return factory(Provider::class)->create()->id;
        },
        'model_id'    => $model->id,
        'model_type'  => get_class($model),
    ];
});
