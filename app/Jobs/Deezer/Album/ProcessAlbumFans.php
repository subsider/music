<?php

namespace App\Jobs\Deezer\Album;

use App\Http\Clients\Deezer\DeezerClient;
use App\Jobs\Deezer\Traits\HasGuards;
use App\Repositories\Deezer\AlbumRepository;
use App\Repositories\Deezer\ArtistRepository;
use App\Repositories\Deezer\AuthorRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessAlbumFans implements ShouldQueue
{
    use HasGuards, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    private $id;

    /**
     * Create a new job instance.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param DeezerClient $client
     * @param AlbumRepository $albumRepository
     * @param AuthorRepository $authorRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(DeezerClient $client, AlbumRepository $albumRepository, AuthorRepository $authorRepository)
    {
        $album = $this->guardAgainstNullAlbum();

        $results = $client->album()->fans($this->id)->limit(DeezerClient::MAX_LIMIT)->get();

        foreach ($results['data'] as $result) {
            $author = $albumRepository->addAuthor($album, $result);
            $authorRepository->addImages($author, [
                'avatar'  => $result['picture_small'],
                'cover'   => $result['picture_medium'],
                'picture' => $result['picture_big'],
                'large'   => $result['picture_xl'],
            ]);
        }
    }
}
