<?php

namespace App\Http\Clients\Deezer;

class TrackResource
{
    /**
     * @var DeezerClient
     */
    private $client;

    /**
     * AlbumResource constructor.
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
        $this->client->url = 'track/' . $id;

        return $this->client;
    }
}
