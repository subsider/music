<?php

namespace App\Http\Clients\Musicbrainz;

use GuzzleHttp\Client;

class MusicbrainzClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    public $query;

    /**
     * @var $string
     */
    public $url;

    /**
     * LastfmClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client(['base_uri' => config('clients.musicbrainz.api_url')]);

        $this->query = [
            'fmt' => 'json'
        ];
    }

    public function artist()
    {
        return new ArtistResource($this);
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get()
    {
        $response = $this->client->request('GET', $this->url, [
            'query' => $this->query,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
