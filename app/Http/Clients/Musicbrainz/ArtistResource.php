<?php

namespace App\Http\Clients\Musicbrainz;

class ArtistResource
{
    /**
     * @var MusicbrainzClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param MusicbrainzClient $client
     */
    public function __construct(MusicbrainzClient $client)
    {
        $this->client = $client;
    }

    public function search(string $artist)
    {
        $this->client->query = array_merge([
            'query' => $artist,
        ], $this->client->query);

        $this->client->url = 'artist';

        return $this->client;
    }
}
