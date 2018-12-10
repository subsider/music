<?php

namespace App\Repositories\Setlistfm;

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

    /**
     * @param Artist $artist
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addService(Artist $artist, array $attributes)
    {
        $service = $artist->services()->updateOrCreate([
            'provider_id' => config('clients.setlistfm.id'),
        ], [
            'web_url'     => $attributes['url'],
            'api_url'     => config('clients.setlistfm.api_url') . "/artist/{$attributes['mbid']}",
            'internal_id' => $attributes['mbid'],
        ]);

        return $service;
    }
}
