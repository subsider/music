<?php

namespace App\Jobs\Deezer\Artist;

use App\Http\Clients\Deezer\DeezerClient;
use App\Jobs\Deezer\Traits\HasGuards;
use App\Repositories\Deezer\ArtistRepository;
use App\Repositories\Deezer\AuthorRepository;
use App\Repositories\Deezer\ChartRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistPlaylists implements ShouldQueue
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
     * @param AuthorRepository $authorRepository
     * @param ChartRepository $chartRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(
        DeezerClient $client,
        ArtistRepository $artistRepository,
        AuthorRepository $authorRepository,
        ChartRepository $chartRepository
    )
    {
        $artist = $this->guardAgainstNullArtist();

        $results = $client->artist()->playlists($this->id)->limit($client::MAX_LIMIT)->get();

        foreach ($results['data'] as $result) {
            $author   = $artistRepository->addAuthor($artist, $result['user']);
            $playlist = $authorRepository->addPlaylist($author, $result);

            $chartRepository->addImages($playlist, [
                'avatar'  => $result['picture_small'],
                'cover'   => $result['picture_medium'],
                'picture' => $result['picture_big'],
                'large'   => $result['picture_xl'],
            ]);
        }
    }
}
