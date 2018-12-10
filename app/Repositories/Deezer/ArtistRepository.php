<?php

namespace App\Repositories\Deezer;

use App\Models\Music\Artist;

class ArtistRepository
{
    protected $types = [
        'avatar'  => 2,
        'cover'   => 4,
        'picture' => 5,
        'large'   => 6,
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

        if ($attributes['nb_album']) {
            $artist->album_count = $attributes['nb_album'];
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
            'provider_id' => config('clients.deezer.id'),
        ], [
            'api_url'     => config('clients.deezer.api_url') . "artists/{$artist->name}",
            'web_url'     => $attributes['link'],
            'internal_id' => $attributes['id']
        ]);

        if (isset($attributes['nb_fan'])) {
            $service->listeners = $attributes['nb_fan'];
        }

        if (isset($attributes['radio'])) {
            $service->streamable = !!$attributes['radio'];
        }

        if (isset($attributes['tracklist'])) {
            $service->tracklist_url = strtok($attributes['tracklist'], '?');
        }

        if ($service->isDirty()) {
            $service->save();
        }

        return $service;
    }

    /**
     * @param Artist $artist
     * @param array $attributes
     */
    public function addImages(Artist $artist, array $attributes)
    {
        foreach ($attributes as $type => $src) {
            $artist->images()->updateOrCreate([
                'provider_id'   => config('clients.bandsintown.id'),
                'image_type_id' => $this->types[$type],
            ], [
                'src' => $src
            ]);
        }
    }
}
