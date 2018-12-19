<?php

namespace App\Http\Clients\Deezer;

class AlbumResource
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
        $this->client->url = 'album/' . $id;

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function fans(int $id)
    {
        $this->client->url = 'album/' . $id . '/fans';

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function tracks(int $id)
    {
        $this->client->url = 'album/' . $id . '/tracks';

        return $this->client;
    }
}
