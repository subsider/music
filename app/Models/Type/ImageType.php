<?php

namespace App\Models\Type;

use App\Models\BaseModel;
use App\Models\Media\Image;

class ImageType extends BaseModel
{
    /**
     * Bandsintown
     * Large: 720x720
     * Thumb: 300x300
     */

    /**
     * Bandsintown
     * XL: 1000x1000
     * Big: 500x500
     * Medium: 250x250
     * Small: 56x56
     */

    /**
     * Bandsintown
     * Cover: 600x600
     * Thumb: 150x150
     */

    /**
     * Genius
     * Image: 1000x1000
     * Header: 1000x600
     */

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
