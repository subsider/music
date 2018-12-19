<?php

namespace App\Http\Clients\Deezer;

class GenreResource
{
    /**
     * @var DeezerClient
     */
    private $client;

    /**
     * GenreResource constructor.
     * @param DeezerClient $client
     */
    public function __construct(DeezerClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function info(int $id)
    {
        $this->client->url = 'genre/' . $id;

        return $this->client;
    }
}
