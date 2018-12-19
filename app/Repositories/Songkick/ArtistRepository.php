<?php

namespace App\Repositories\Songkick;

use App\Models\Music\Artist;
use Carbon\Carbon;

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
            'name' => $attributes['displayName'],
        ]);

        if (isset($attributes['onTourUntil']) && $attributes['onTourUntil']) {
            $artist->on_tour_until = Carbon::parse($attributes['onTourUntil']);
        }

        if (isset($attributes['identifier'][0]['mbid']) && $attributes['identifier'][0]['mbid'] != '') {
            $artist->mbid = $attributes['identifier'][0]['mbid'];
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
            'provider_id' => config('clients.songkick.id'),
        ], [
            'web_url'     => strtok($attributes['uri'], '?'),
            'internal_id' => $attributes['id'],
        ]);

        if (!empty($attributes['identifier'])) {
            $service->api_url = $attributes['identifier'][0]['href'];
        }

        if ($service->isDirty()) {
            $service->save();
        }

        return $service;
    }
}
