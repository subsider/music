<?php

namespace App\Models\Provider;

use App\Models\BaseModel;
use App\Models\Media\Image;

class Provider extends BaseModel
{
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
