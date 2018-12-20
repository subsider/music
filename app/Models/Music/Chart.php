<?php

namespace App\Models\Music;

use App\Models\BaseModel;
use App\Models\Media\Image;
use App\Models\Provider\Publication;
use App\Models\Type\ChartType;

class Chart extends BaseModel
{
    const ARTIST = 1;
    const ALBUM = 2;
    const TRACK = 3;
    const PLAYLIST = 4;

    protected $dates = ['crawled_at'];

    public function type()
    {
        return $this->belongsTo(ChartType::class, 'chart_type_id');
    }

    public function genre()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function chartItems()
    {
        return $this->belongsToMany(
            ChartItem::class,
            'PIVOT',
            'chart_id',
            'item_id'
        )->withTimestamps();
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
        )->withPivot('rank', 'score')
            ->orderBy('rank')
            ->withTimestamps();
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
