<?php

namespace App\Models\Music;

use App\Models\BaseModel;
use App\Models\Media\Image;

class Chart extends BaseModel
{
    const ARTIST = 1;
    const ALBUM = 2;
    const TRACK = 3;
    const PLAYLIST = 4;

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function tracks()
    {
        return $this->belongsToMany(
            Track::class,
            'chart_items',
            'chart_id',
            'item_id'
        )->withTimestamps();
    }

    public function albums()
    {
        return $this->belongsToMany(
            Album::class,
            'chart_items',
            'chart_id',
            'item_id'
        )->withTimestamps();
    }

    public function artists()
    {
        return $this->belongsToMany(
            Artist::class,
            'chart_items',
            'chart_id',
            'item_id'
        )->withTimestamps();
    }

    public function playlists()
    {
        return $this->belongsToMany(
            Chart::class,
            'chart_items',
            'chart_id',
            'item_id'
        )->withTimestamps();
    }
}
