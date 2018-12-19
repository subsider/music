<?php

namespace App\Models\People;

use App\Models\BaseModel;
use App\Models\Media\Image;
use App\Models\Music\Artist;

class Author extends BaseModel
{
    public function artists()
    {
        return $this->morphMany(Artist::class, 'model')
            ->where('model_type', 'App\Models\Music\Artist');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }
}
