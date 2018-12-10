<?php

namespace App\Http\Clients\Deezer;

class ArtistResource
{
    /**
     * @var DeezerClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param DeezerClient $client
     */
    public function __construct(DeezerClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $artist
     * @return DeezerClient
     */
    public function search(string $artist)
    {
        $this->client->query = [
            'query' => [
                'q' => "artist:\"{$artist}\"",
            ],
        ];

        $this->client->url = 'search/artist';

        return $this->client;
    }
}
