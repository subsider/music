<?php

namespace App\Jobs\Deezer\Artist;

use App\Exceptions\ArtistNotFoundException;
use App\Http\Clients\Deezer\DeezerClient;
use App\Repositories\Deezer\ArtistRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * @throws ArtistNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(DeezerClient $client, ArtistRepository $artistRepository)
    {
        $result = $client->artist()->info($this->id)->get();

        try {
            $artist = $artistRepository->create($result);
            $artistRepository->addService($artist, $result);
            $artistRepository->addImages($artist, [
                'avatar'  => $result['picture_small'],
                'cover'   => $result['picture_medium'],
                'picture' => $result['picture_big'],
                'large'   => $result['picture_xl'],
            ]);
        } catch (\Exception $e) {
            throw new ArtistNotFoundException;
        }
    }
}
