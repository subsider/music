<?php

namespace App\Models\Music;

use App\Models\BaseModel;
use App\Models\Media\Image;

class Radio extends BaseModel
{
    const TRACK = 3;

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'radio_tracks')
            ->withPivot('rank')
            ->withTimestamps();
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function genres()
    {
        return $this->morphToMany(
            Genre::class,
            'taggable',
            'taggables',
            'tag_id',
            'taggable_id'
        );
    }
}
