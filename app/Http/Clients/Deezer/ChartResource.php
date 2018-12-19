<?php

namespace App\Http\Clients\Deezer;

class ChartResource
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
     * @return DeezerClient
     */
    public function info()
    {
        $this->client->url = 'chart';

        return $this->client;
    }
}
