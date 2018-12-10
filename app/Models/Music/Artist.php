<?php

namespace App\Models\Music;

use App\Models\BaseModel;
use App\Models\Media\Image;
use App\Models\Provider\Provider;
use App\Models\Provider\Service;

class Artist extends BaseModel
{
    public function services()
    {
        return $this->morphMany(Service::class, 'model');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function providers()
    {
        return $this->belongsToMany(
            Provider::class,
            'services',
            'model_id',
            'id'
        );
    }
}
