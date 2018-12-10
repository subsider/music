<?php

namespace App\Http\Clients\Itunes;

class ArtistResource
{
    /**
     * @var ItunesClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param ItunesClient $client
     */
    public function __construct(ItunesClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $artist
     * @return ItunesClient
     */
    public function search(string $artist)
    {
        $this->client->query = [
            'term'   => $artist,
            'entity' => 'musicArtist'
        ];

        $this->client->url = 'search';

        return $this->client;
    }
}
