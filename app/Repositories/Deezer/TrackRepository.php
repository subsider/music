<?php

namespace App\Repositories\Deezer;

use App\Models\Music\Album;
use App\Models\Music\Artist;
use App\Models\Music\Contributor;
use App\Models\Music\Track;

class TrackRepository
{
    /**
     * @var Track
     */
    private $track;

    /**
     * TrackRepository constructor.
     * @param Track $track
     */
    public function __construct(Track $track)
    {
        $this->track = $track;
    }

    /**
     * @param Track $track
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addService(Track $track, array $attributes)
    {
        $service = $track->services()->firstOrNew([
            'provider_id' => config('clients.deezer.id'),
        ], [
            'api_url'     => config('clients.deezer.api_url') . "artist/{$attributes['id']}",
            'internal_id' => $attributes['id']
        ]);

        if (isset($attributes['link'])) {
            $service->web_url = $attributes['link'];
        }

        if (isset($attributes['preview'])) {
            $service->preview_url = $attributes['preview'];
        }

        if (isset($attributes['rank'])) {
            $service->rank = $attributes['rank'];
        }

        if (isset($attributes['readdable'])) {
            $service->streamable = $attributes['readdable'];
        }

        if (isset($attributes['readable'])) {
            $service->streamable = $attributes['readable'];
        }

        if ($service->isDirty()) {
            $service->save();
        }

        return $service;
    }

    /**
     * @param Track $track
     * @param Artist $artist
     * @param Album $album
     * @param string $role
     * @return mixed
     */
    public function addContributor(Track $track, Artist $artist, Album $album, string $role)
    {
        $contributor = Contributor::updateOrCreate([
            'artist_id'    => $artist->id,
            'model_id'     => $track->id,
            'model_type'   => get_class($track),
            'context_id'   => $album->id,
            'context_type' => get_class($album),
            'role'         => $role,
        ]);

        return $contributor;
    }
}
