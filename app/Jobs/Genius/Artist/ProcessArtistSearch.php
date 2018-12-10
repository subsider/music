<?php

namespace App\Jobs\Genius\Artist;

use App\Http\Clients\Genius\GeniusClient;
use App\Repositories\Genius\ArtistRepository;
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
     * @param GeniusClient $client
     * @param ArtistRepository $artistRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(GeniusClient $client, ArtistRepository $artistRepository)
    {
        $results = $client->artist()->search($this->artist)->get();

        foreach ($results['response']['hits'] as $result) {
            $artistResult = $result['result']['primary_artist'];
            $artist       = $artistRepository->create($artistResult);
            $artistRepository->addService($artist, $artistResult);
            $artistRepository->addImages($artist, [
                'large'  => $artistResult['image_url'],
                'header' => $artistResult['header_image_url'],
            ]);
        }
    }
}
