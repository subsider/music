<?php

namespace App\Models\Music;

use App\Models\BaseModel;
use App\Models\Event\Event;
use App\Models\Media\Image;
use App\Models\People\Fan;
use App\Models\Provider\Provider;
use App\Models\Provider\Service;
use App\Models\Type\ImageType;

class Artist extends BaseModel
{
    protected $dates = ['on_tour_until'];

    public function services()
    {
        return $this->morphMany(Service::class, 'model');
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'artist_album');
    }

    public function tracks()
    {
        return $this->belongsToMany(Track::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function thumb()
    {
        return $this->hasOne(Image::class, 'model_id')
            ->where('model_type', 'App\Models\Music\Artist')
            ->where('image_type_id', ImageType::THUMB);
    }

    public function cover()
    {
        return $this->hasOne(Image::class, 'model_id')
            ->where('model_type', 'App\Models\Music\Artist')
            ->where('image_type_id', ImageType::COVER);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'lineup')->withTimestamps();
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
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

    public function related()
    {
        return $this->morphMany(Related::class, 'model');
    }

    public function fans()
    {
        return $this->morphMany(Fan::class, 'model');
    }
}
