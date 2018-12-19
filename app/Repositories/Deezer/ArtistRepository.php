<?php

namespace App\Repositories\Deezer;

use App\Models\Music\Album;
use App\Models\Music\Artist;
use App\Models\People\Author;
use App\Models\People\Fan;
use Carbon\Carbon;

class ArtistRepository
{
    /**
     * @var array
     */
    protected $types = [
        'avatar'  => 2,
        'cover'   => 4,
        'picture' => 5,
        'large'   => 6,
    ];

    protected $albumTypes = [
        'album'   => 1,
        'single'  => 2,
        'compile' => 3,
        'ep'      => 4,
        'bundle'  => 5,
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

        if (isset($attributes['nb_album'])) {
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
            'api_url'     => config('clients.deezer.api_url') . "artist/{$attributes['id']}",
            'internal_id' => $attributes['id']
        ]);

        if (isset($attributes['link'])) {
            $service->web_url = $attributes['link'];
        }

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
     * @return Album
     */
    public function addAlbum(Artist $artist, array $attributes)
    {
        /** @var Album $album */
        $album = $artist->albums()->where([
            'name' => $attributes['title'],
        ])->first();

        if (!$album) {
            $album = new Album(['name' => $attributes['title']]);
        }

        if (isset($attributes['release_date'])) {
            $album->release_date = Carbon::parse($attributes['release_date']);
            $album->year = $album->release_date->year;
        }

        if (isset($attributes['record_type'])) {
            $album->album_type_id = $this->albumTypes[$attributes['record_type']];
        }

        if (isset($attributes['duration'])) {
            $album->duration = $attributes['duration'];
        }

        if (isset($attributes['explicit_lyrics'])) {
            $album->explicit_lyrics = $attributes['explicit_lyrics'];
        }

        if (isset($attributes['nb_tracks'])) {
            $album->track_count = $attributes['nb_tracks'];
        }

        if (isset($attributes['upc'])) {
            $album->upc = $attributes['upc'];
        }

        if ($album->isDirty()) {
            $album->save();
        }

        $artist->albums()->syncWithoutDetaching($album);

        return $album;
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

    /**
     * @param Artist $artist
     * @param Artist $relatedArtist
     */
    public function addRelated(Artist $artist, Artist $relatedArtist)
    {
        $artist->related()->updateOrCreate([
            'related_id' => $relatedArtist->id,
        ]);
    }

    /**
     * @param Artist $artist
     * @param array $attributes
     * @return mixed
     */
    public function addAuthor(Artist $artist, array $attributes)
    {
        $author = Author::firstOrNew([
            'provider_id'   => config('clients.deezer.id'),
            'internal_id'   => $attributes['id'],
            'username'      => $attributes['name'],
            'tracklist_url' => $attributes['tracklist'],
        ]);

        if (isset($attributes['link'])) {
            $author->web_url = $attributes['link'];
        }

        if ($author->isDirty()) {
            $author->save();
        }

        Fan::updateOrCreate([
            'model_id'     => $author->id,
            'model_type'   => get_class($author),
            'context_id'   => $artist->id,
            'context_type' => get_class($artist),
        ]);

        return $author;
    }

}
