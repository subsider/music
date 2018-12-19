<?php

namespace App\Repositories\Musicbrainz;

use App\Models\Music\Artist;

class ArtistRepository
{
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

        if (isset($attributes['id']) && $attributes['id'] != '') {
            $artist->mbid = $attributes['id'];
        }

        if ($artist->isDirty()) {
            $artist->save();
        }

        return $artist;
    }

    public function addService(Artist $artist, array $attributes)
    {
        $service = $artist->services()->updateOrCreate([
            'provider_id' => config('clients.musicbrainz.id'),
        ]);

        if (isset($attributes['id']) && $attributes['id'] != '') {
            $service->internal_id = $attributes['id'];
            $service->web_url     = config('clients.musicbrainz.web_url') . "artist/{$attributes['id']}";
            $service->api_url     = config('clients.musicbrainz.api_url') . "artist/{$attributes['id']}?fmt=json";
        }

        if ($service->isDirty()) {
            $service->save();
        }

        return $service;
    }
}
