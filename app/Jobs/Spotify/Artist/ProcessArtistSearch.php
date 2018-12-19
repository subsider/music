<?php

namespace App\Jobs\Spotify\Artist;

use App\Http\Clients\Spotify\SpotifyClient;
use App\Repositories\Spotify\ArtistRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $artist;

    /**
     * Create a new job instance.
     *
     * @param string $artist
     */
    public function __construct(string $artist)
    {
        $this->artist = $artist;
    }

    /**
     * @param SpotifyClient $client
     * @param ArtistRepository $artistRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(SpotifyClient $client, ArtistRepository $artistRepository)
    {
        $results = $client->artist()->search($this->artist)->get();

        foreach ($results['artists']['items'] as $result) {
            $artist = $artistRepository->create($result);
            $artistRepository->addService($artist, $result);
        }
    }
}
