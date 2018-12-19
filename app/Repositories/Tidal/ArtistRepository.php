<?php

namespace App\Repositories\Tidal;

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
        $artist = $this->artist->updateOrCreate([
            'name' => $attributes['name'],
        ]);

        return $artist;
    }

    /**
     * @param Artist $artist
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addService(Artist $artist, array $attributes)
    {
        $service = $artist->services()->updateOrCreate([
            'provider_id' => config('clients.tidal.id'),
        ], [
            'web_url'     => $attributes['url'],
            'api_url'     => config('clients.tidal.api_url') . "/artists/{$attributes['id']}?countryCode=ES",
            'internal_id' => $attributes['id'],
            'popularity'  => $attributes['popularity'],
        ]);

        return $service;
    }
}
