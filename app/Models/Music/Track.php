<?php

namespace App\Models\Music;

use App\Models\BaseModel;
use App\Models\Provider\Service;

class Track extends BaseModel
{
    public function services()
    {
        return $this->morphMany(Service::class, 'model');
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class)
            ->withPivot('position', 'duration', 'disk_number', 'isrc', 'gain', 'bpm')
            ->withTimestamps();
    }
}
