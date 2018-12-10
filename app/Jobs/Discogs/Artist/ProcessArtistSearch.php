<?php

namespace App\Jobs\Discogs\Artist;

use App\Http\Clients\Discogs\DiscogsClient;
use App\Repositories\Discogs\ArtistRepository;
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
     * @param DiscogsClient $client
     * @param ArtistRepository $artistRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(DiscogsClient $client, ArtistRepository $artistRepository)
    {
        $results = $client->artist()->search($this->artist)->get();

        foreach ($results['results'] as $result) {
            $artist = $artistRepository->create($result);
            $artistRepository->addService($artist, $result);
            $artistRepository->addImages($artist, [
                'thumb' => $result['thumb'],
                'cover' => $result['cover_image'],
            ]);
        }
    }
}
