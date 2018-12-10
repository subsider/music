<?php

namespace App\Http\Clients\Napster;

class ArtistResource
{
    /**
     * @var NapsterClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param NapsterClient $client
     */
    public function __construct(NapsterClient $client)
    {
        $this->client        = $client;
        $this->client->query = [
            'type' => 'artist',
        ];
    }

    /**
     * @param string $artist
     * @return NapsterClient
     */
    public function search(string $artist)
    {
        $this->client->query = array_merge([
            'query' => $artist,
        ], $this->client->query);

        $this->client->url = 'search';

        return $this->client;
    }
}
