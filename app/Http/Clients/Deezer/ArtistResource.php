<?php

namespace App\Http\Clients\Deezer;

class ArtistResource
{
    /**
     * @var DeezerClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param DeezerClient $client
     */
    public function __construct(DeezerClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $artist
     * @return DeezerClient
     */
    public function search(string $artist)
    {
        $this->client->query = [
            'query' => [
                'q' => "artist:\"{$artist}\"",
            ],
        ];

        $this->client->url = 'search/artist';

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function info(int $id)
    {
        $this->client->url = 'artist/' . $id;

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function albums(int $id)
    {
        $this->client->url = 'artist/' . $id . '/albums';

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function tracks(int $id)
    {
        $this->client->url = 'artist/' . $id . '/top';

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function related(int $id)
    {
        $this->client->url = 'artist/' . $id . '/related';

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function fans(int $id)
    {
        $this->client->url = 'artist/' . $id . '/fans';

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function comments(int $id)
    {
        $this->client->url = 'artist/' . $id . '/comments';

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function radio(int $id)
    {
        $this->client->url = 'artist/' . $id . '/radio';

        return $this->client;
    }

    /**
     * @param int $id
     * @return DeezerClient
     */
    public function playlists(int $id)
    {
        $this->client->url = 'artist/' . $id . '/playlists';

        return $this->client;
    }
}
