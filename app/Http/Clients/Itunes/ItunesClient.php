<?php

namespace App\Http\Clients\Itunes;

use GuzzleHttp\Client;

class ItunesClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    public $url;

    /**
     * @var array
     */
    public $query;

    /**
     * ItunesClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client(['base_uri' => config('clients.itunes.api_url')]);
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
