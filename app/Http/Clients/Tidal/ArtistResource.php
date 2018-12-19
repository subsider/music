<?php

namespace App\Http\Clients\Tidal;

class ArtistResource
{
    /**
     * @var TidalClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param TidalClient $client
     */
    public function __construct(TidalClient $client)
    {
        $this->client = $client;
    }

    public function search(string $artist)
    {
        $this->client->query = array_merge([
            'query' => $artist,
            'types' => 'ARTISTS'
        ], $this->client->query);

        $this->client->url = 'search';

        return $this->client;
    }
}
