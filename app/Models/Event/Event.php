<?php

namespace App\Models\Event;

use App\Models\BaseModel;
use App\Models\Music\Artist;
use App\Models\Provider\Service;

class Event extends BaseModel
{
    protected $dates = ['celebration_date', 'on_sale_date', 'deleted_at'];

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'lineup')->withTimestamps();
    }

    public function services()
    {
        return $this->morphMany(Service::class, 'model');
    }

    public function offers()
    {
        return $this->hasMany(EventOffer::class, 'event_id');
    }
}
