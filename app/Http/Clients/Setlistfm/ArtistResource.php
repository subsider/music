<?php

namespace App\Http\Clients\Setlistfm;

class ArtistResource
{
    /**
     * @var SetlistfmClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param SetlistfmClient $client
     */
    public function __construct(SetlistfmClient $client)
    {
        $this->client = $client;
    }

    public function search(string $artist)
    {
        $this->client->query = [
            'artistName' => $artist,
        ];

        $this->client->url = 'search/artists';

        return $this->client;
    }
}
