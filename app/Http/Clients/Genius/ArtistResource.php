<?php

namespace App\Http\Clients\Genius;

class ArtistResource
{
    /**
     * @var GeniusClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param GeniusClient $client
     */
    public function __construct(GeniusClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $artist
     * @return GeniusClient
     */
    public function search(string $artist)
    {
        $this->client->query = [
            'q' => $artist,
        ];

        $this->client->url = 'search';

        return $this->client;
    }
}
