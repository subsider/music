<?php

namespace App\Repositories\Deezer;

use App\Models\Music\Album;
use App\Models\Music\AlbumTrack;
use App\Models\Music\Artist;
use App\Models\Music\Contributor;
use App\Models\Music\Genre;
use App\Models\Music\Label;
use App\Models\Music\Taggable;
use App\Models\Music\Track;
use App\Models\People\Author;
use App\Models\People\Fan;
use App\Models\Provider\Service;
use App\Models\Type\ImageType;

class AlbumRepository
{
    /**
     * @var array
     */
    protected $imageTypes = [
        'avatar'  => 2,
        'cover'   => 4,
        'picture' => 5,
        'large'   => 6,
    ];

    /**
     * @var Album
     */
    private $album;

    /**
     * ArtistRepository constructor.
     * @param Album $album
     */
    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    /**
     * @param Album $album
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addService(Album $album, array $attributes)
    {
        $service = $album->services()->firstOrNew([
            'provider_id' => config('clients.deezer.id'),
        ], [
            'api_url'     => config('clients.deezer.api_url') . "album/{$attributes['id']}",
            'internal_id' => $attributes['id']
        ]);

        if (isset($attributes['link'])) {
            $service->web_url = $attributes['link'];
        }

        if (isset($attributes['fans'])) {
            $service->listeners = $attributes['fans'];
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
     * @param Album $album
     * @param array $attributes
     * @param int|null $position
     * @return Track
     */
    public function addTrack(Album $album, array $attributes, int $position = null)
    {
        /** @var Track $track */
        $track = $album->tracks()->where([
            'name' => $attributes['title'],
        ])->first();

        if (!$track) {
            $track = new Track(['name' => $attributes['title']]);
        }

        if (isset($attributes['title_short'])) {
            $track->short_name = $attributes['title_short'];
        }

        if (isset($attributes['title_version'])) {
            $track->version_name = $attributes['title_short'];
        }

        if (isset($attributes['explicit_lyrics'])) {
            $track->explicit_lyrics = $attributes['explicit_lyrics'];
        }

        if ($track->isDirty()) {
            $track->save();
        }

        $fill = [];

        if (isset($attributes['duration'])) {
            $fill['duration'] = $attributes['duration'];
        }

        if (isset($position)) {
            $fill['position'] = $position;
        }

        if (isset($attributes['isrc'])) {
            $fill['isrc'] = $attributes['isrc'];
        }

        if (isset($attributes['disk_number'])) {
            $fill['disk_number'] = $attributes['disk_number'];
        }

        if (isset($attributes['bpm'])) {
            $fill['bpm'] = $attributes['bpm'];
        }

        if (isset($attributes['gain'])) {
            $fill['gain'] = $attributes['gain'];
        }

        try {
            $album->tracks()->save($track, $fill);
        } catch (\Exception $e) {
            $album->tracks()->updateExistingPivot($track, $fill);
        }

        return $track;
    }

    /**
     * @param Album $album
     * @param array $attributes
     */
    public function addImages(Album $album, array $attributes)
    {
        foreach ($attributes as $type => $src) {
            if ($src != '') {
                $album->images()->updateOrCreate([
                    'provider_id'   => config('clients.bandsintown.id'),
                    'image_type_id' => $this->imageTypes[$type],
                ], [
                    'src' => $src
                ]);
            }
        }
    }

    /**
     * @param Album $album
     * @param int $id
     * @param string $src
     * @return null
     */
    public function addTag(Album $album, int $id, string $src = null)
    {
        $service = Service::where([
            'internal_id' => $id,
            'model_type'  => 'App\Models\Music\Genre',
            'provider_id' => config('clients.deezer.id'),
        ])->first();

        if ($service) {
            try {
                Taggable::updateOrCreate([
                    'tag_id'        => $service->model_id,
                    'taggable_id'   => $album->id,
                    'taggable_type' => get_class($service->model),
                ]);

                if ($src) {
                    $genre = Genre::find($service->model_id);

                    $genre->images()->updateOrCreate([
                        'provider_id'   => config('clients.deezer.id'),
                        'image_type_id' => ImageType::AVATAR,
                        'src'           => $src,
                    ]);
                }

            } catch (\Exception $e) {
                info('Cannot tag the album');
            }
        }
    }

    /**
     * @param Album $album
     * @param Artist $artist
     * @param string $role
     * @return mixed
     */
    public function addContributor(Album $album, Artist $artist, string $role)
    {
        $contributor = Contributor::updateOrCreate([
            'artist_id'  => $artist->id,
            'model_id'   => $album->id,
            'model_type' => get_class($album),
            'role'       => $role,
        ]);

        return $contributor;
    }

    public function addLabel(Album $album, string $name)
    {
        $label = Label::updateOrCreate(['name' => $name]);

        $album->labels()->syncWithoutDetaching($label);

        return $label;
    }

    /**
     * @param Album $album
     * @param array $attributes
     * @return mixed
     */
    public function addAuthor(Album $album, array $attributes)
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
            'context_id'   => $album->id,
            'context_type' => get_class($album),
        ]);

        return $author;
    }
}
