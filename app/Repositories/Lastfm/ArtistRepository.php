<?php

namespace App\Repositories\Lastfm;

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

        if (isset($attributes['mbid']) && $attributes['mbid'] != '') {
            $artist->mbid = $attributes['mbid'];
        }

        if ($artist->isDirty()) {
            $artist->save();
        }

        return $artist;
    }

    public function addService(Artist $artist, array $attributes)
    {
        $encodedArtistName = urlencode($artist->name);
        $service = $artist->services()->updateOrCreate([
            'provider_id' => config('clients.lastfm.id'),
        ], [
            'api_url' => config('clients.lastfm.api_url') . "?method=artist.search&artist={$encodedArtistName}&format=json",
            'web_url' => config('clients.lastfm.web_url') . $encodedArtistName,
        ]);

        if (isset($attributes['mbid']) && $attributes['mbid'] != '') {
            $service->internal_id = $attributes['mbid'];
        }

        if (isset($attributes['streamable'])) {
            $service->streamable = !! $attributes['streamable'];
        }

        if (isset($attributes['listeners'])) {
            $service->listeners = $attributes['listeners'];
        }

        if ($service->isDirty()) {
            $service->save();
        }

        return $service;
    }
}
