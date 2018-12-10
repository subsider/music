<?php

namespace App\Repositories\Bandsintown;

use App\Models\Music\Artist;

class ArtistRepository
{
    protected $types = [
        'cover'   => 4,
        'picture' => 5,
    ];

    /**
     * @var Artist
     */
    private $artist;

    /**
     * ArtistRepository constructor.
     * @param Artist $artist
     */
    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $artist = $this->artist->firstOrNew([
            'name' => $attributes['name'],
        ]);

        if (isset($attributes['mbid']) && $attributes['mbid'] != '') {
            $artist->mbid = $attributes['mbid'];
        }

        if (isset($attributes['facebook_page_url']) && $attributes['facebook_page_url'] != '') {
            $artist->facebook_page_url = $attributes['facebook_page_url'];
        }

        if ($artist->isDirty()) {
            $artist->save();
        }

        return $artist;
    }

    /**
     * @param Artist $artist
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addService(Artist $artist, array $attributes)
    {
        $service = $artist->services()->firstOrNew([
            'provider_id' => config('clients.bandsintown.id'),
        ], [
            'api_url' => config('clients.bandsintown.api_url') . "artists/{$artist->name}",
            'web_url' => strtok($attributes['url'], '?'),
        ]);

        if ($attributes['id']) {
            $service->internal_id = $attributes['id'];
        }

        if (isset($attributes['tracker_count'])) {
            $service->count = $attributes['tracker_count'];
        }

        if ($service->isDirty()) {
            $service->save();
        }

        return $service;
    }

    /**
     * @param Artist $artist
     * @param array $results
     */
    public function addImages(Artist $artist, array $results)
    {
        foreach ($results as $type => $src) {
            $artist->images()->updateOrCreate([
                'provider_id'   => config('clients.bandsintown.id'),
                'image_type_id' => $this->types[$type],
            ], [
                'src' => $src
            ]);
        }
    }
}
