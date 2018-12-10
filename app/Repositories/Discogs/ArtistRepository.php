<?php

namespace App\Repositories\Discogs;

use App\Models\Music\Artist;

class ArtistRepository
{
    protected $types = [
        'thumb' => 3,
        'cover' => 4,
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
            'name' => $attributes['title'],
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
            'provider_id' => config('clients.discogs.id'),
        ], [
            'api_url'     => $attributes['resource_url'],
            'web_url'     => config('clients.discogs.web_url') . $attributes['uri'],
            'internal_id' => $attributes['id']
        ]);

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
            if ($src != '') {
                $artist->images()->updateOrCreate([
                    'provider_id'   => config('clients.discogs.id'),
                    'image_type_id' => $this->types[$type],
                ], [
                    'src' => $src
                ]);
            }
        }
    }
}
