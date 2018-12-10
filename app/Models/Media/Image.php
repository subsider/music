<?php

namespace App\Models\Media;

use App\Models\BaseModel;
use App\Models\Provider\Provider;
use App\Models\Type\ImageType;

class Image extends BaseModel
{
    public function type()
    {
        return $this->belongsTo(ImageType::class, 'image_type_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
