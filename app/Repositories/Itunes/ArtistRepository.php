<?php

namespace App\Repositories\Itunes;

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
            'name' => $attributes['artistName'],
        ]);

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
        $url = strtok($attributes['artistLinkUrl'], '?');

        $service = $artist->services()->firstOrNew([
            'provider_id' => config('clients.itunes.id'),
        ], [
            'api_url'     => $url,
            'web_url'     => $url,
            'internal_id' => $attributes['artistId']
        ]);

        if ($service->isDirty()) {
            $service->save();
        }

        return $service;
    }
}
