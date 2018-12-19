<?php

namespace App\Repositories\Deezer;

use App\Models\Music\Artist;
use App\Models\Music\Chart;
use App\Models\People\Author;
use App\Models\People\Comment;
use Carbon\Carbon;

class AuthorRepository
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

    /**
     * @var Author
     */
    private $author;

    /**
     * AuthorRepository constructor.
     * @param Author $author
     */
    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    /**
     * @param Author $author
     * @param array $attributes
     */
    public function addImages(Author $author, array $attributes)
    {
        foreach ($attributes as $type => $src) {
            $author->images()->updateOrCreate([
                'provider_id'   => config('clients.bandsintown.id'),
                'image_type_id' => $this->types[$type],
            ], [
                'src' => $src
            ]);
        }
    }

    /**
     * @param Author $author
     * @param Artist $artist
     * @param array $attributes
     * @return mixed
     */
    public function addComment(Author $author, Artist $artist, array $attributes)
    {
        $comment = Comment::updateOrCreate([
            'internal_id'  => $attributes['id'],
            'model_id'     => $author->id,
            'model_type'   => get_class($author),
            'context_id'   => $artist->id,
            'context_type' => get_class($artist),
            'body'         => $attributes['text'],
            'published_at' => Carbon::createFromTimestamp($attributes['date']),
        ]);

        return $comment;
    }

    /**
     * @param Author $author
     * @param array $attributes
     * @return mixed
     */
    public function addPlaylist(Author $author, array $attributes)
    {
        $playlist = Chart::updateOrCreate([
            'provider_id'   => config('clients.deezer.id'),
            'chart_type_id' => Chart::TRACK,
            'owner_id'      => $author->id,
            'owner_type'    => get_class($author),
            'name'          => config('clients.deezer.name') . ' - ' . $attributes['title'],
            'internal_id'   => $attributes['id'],
            'tracklist_url' => $attributes['tracklist'],
        ], [
            'published_at' => Carbon::parse($attributes['creation_date']),
            'checksum'     => $attributes['checksum'],
            'public'       => !!$attributes['public'],
        ]);

        return $playlist;
    }
}
