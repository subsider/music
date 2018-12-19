<?php

namespace App\Jobs\Deezer\Artist;

use App\Http\Clients\Deezer\DeezerClient;
use App\Jobs\Deezer\Traits\HasGuards;
use App\Repositories\Deezer\AlbumRepository;
use App\Repositories\Deezer\ArtistRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistAlbums implements ShouldQueue
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
     * @param ArtistRepository $artistRepository
     * @param AlbumRepository $albumRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(DeezerClient $client, ArtistRepository $artistRepository, AlbumRepository $albumRepository)
    {
        $artist = $this->guardAgainstNullArtist();

        $results = $client->artist()->albums($this->id)
            ->limit(DeezerClient::MAX_LIMIT)
            ->get();

        foreach ($results['data'] as $result) {
            $album = $artistRepository->addAlbum($artist, $result);
            $albumRepository->addService($album, $result);
            $albumRepository->addImages($album, [
                'avatar'  => $result['cover_small'],
                'cover'   => $result['cover_medium'],
                'picture' => $result['cover_big'],
                'large'   => $result['cover_xl'],
            ]);
            $albumRepository->addTag($album, $result['genre_id']);
        }
    }
}
