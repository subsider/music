<?php

namespace App\Http\Clients\Deezer;

class RadioResource
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
    public function top()
    {
        $this->client->url = 'radio';

        return $this->client;
    }

    /**
     * @return DeezerClient
     */
    public function genres()
    {
        $this->client->url = 'radio/genres';

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function info(int $id)
    {
        $this->client->url = 'radio/' . $id;

        return $this->client;
    }
}
