<?php

namespace App\Repositories\Genius;

use App\Models\Music\Artist;

class ArtistRepository
{
    protected $types = [
        'large'  => 6,
        'header' => 7,
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
            'provider_id' => config('clients.genius.id'),
        ], [
            'api_url'     => config('clients.genius.api_url') . $attributes['api_path'],
            'web_url'     => $attributes['url'],
            'internal_id' => $attributes['id']
        ]);

        if ($service->isDirty()) {
            $service->save();
        }

        return $service;
    }

    public function addImages(Artist $artist, array $attributes)
    {
        foreach ($attributes as $type => $src) {
            $artist->images()->updateOrCreate([
                'provider_id'   => config('clients.genius.id'),
                'image_type_id' => $this->types[$type],
            ], [
                'src' => $src
            ]);
        }
    }
}
