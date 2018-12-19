<?php

namespace App\Http\Clients\Bandsintown;

class ArtistResource
{
    /**
     * @var BandsintownClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param BandsintownClient $client
     */
    public function __construct(BandsintownClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $artist
     * @return BandsintownClient
     */
    public function info(string $artist)
    {
        $this->client->url = "artists/{$artist}";

        return $this->client;
    }

    /**
     * @param string $artist
     * @return BandsintownClient
     */
    public function events(string $artist)
    {
        $this->client->url = "artists/{$artist}/events";

        return $this->client;
    }
}
