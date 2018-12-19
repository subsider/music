<?php

namespace App\Models\Music;

use App\Models\BaseModel;
use App\Models\Media\Image;
use App\Models\Provider\Service;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tag extends BaseModel
{
    use HasSlug;

    const GENRE = 2;

    protected $table = 'tags';

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function services()
    {
        return $this->morphMany(Service::class, 'model');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }
}
