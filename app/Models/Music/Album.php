<?php

namespace App\Models\Music;

use App\Models\BaseModel;
use App\Models\Media\Image;
use App\Models\Provider\Service;
use App\Models\Type\AlbumType;
use App\Music\Genre;

class Album extends BaseModel
{
    protected $dates = ['release_date'];

    public function getFormattedReleaseDateAttribute()
    {
        return $this->release_date->format('Y-m-d');
    }

    public function type()
    {
        return $this->belongsTo(AlbumType::class, 'album_type_id');
    }

    public function services()
    {
        return $this->morphMany(Service::class, 'model');
    }

    public function tracks()
    {
        return $this->belongsToMany(Track::class)
            ->withPivot('position', 'duration', 'disk_number', 'isrc', 'gain', 'bpm')
            ->withTimestamps();
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function genres()
    {
        return $this->morphToMany(Genre::class, 'taggable');
    }

    public function companies()
    {
        return $this->morphToMany(Company::class, 'companiable');
    }

    public function labels()
    {
        return $this->morphToMany(
            Label::class, 'companiable',
            'companiables',
            'companiable_id',
            'company_id'
        );
    }
}
