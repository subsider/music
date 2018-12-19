<?php

namespace App\Models\Geo;

use App\Models\BaseModel;
use App\Models\Event\Event;
use App\Models\Provider\Service;

class Place extends BaseModel
{
    public function services()
    {
        return $this->morphMany(Service::class, 'model');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
