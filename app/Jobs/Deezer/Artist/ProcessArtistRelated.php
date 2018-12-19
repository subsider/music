<?php

namespace App\Jobs\Deezer\Artist;

use App\Http\Clients\Deezer\DeezerClient;
use App\Jobs\Deezer\Traits\HasGuards;
use App\Repositories\Deezer\ArtistRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistRelated implements ShouldQueue
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(DeezerClient $client, ArtistRepository $artistRepository)
    {
        $artist = $this->guardAgainstNullArtist();

        $results = $client->artist()->related($this->id)->limit(DeezerClient::MAX_LIMIT)->get();

        foreach ($results['data'] as $result) {
            $relatedArtist = $artistRepository->create($result);
            $artistRepository->addService($relatedArtist, $result);
            $artistRepository->addImages($relatedArtist, [
                'avatar'  => $result['picture_small'],
                'cover'   => $result['picture_medium'],
                'picture' => $result['picture_big'],
                'large'   => $result['picture_xl'],
            ]);

            $artistRepository->addRelated($artist, $relatedArtist);
            $artistRepository->addRelated($relatedArtist, $artist);
        }
    }
}
