<?php

namespace App\Http\Clients\Genius;

use GuzzleHttp\Client;

class GeniusClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    public $headers;

    /**
     * @var array
     */
    public $query;

    /**
     * @var string
     */
    public $url;

    /**
     * GeniusClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client([
            'base_uri' => config('clients.genius.api_url'),
            'headers'  => [
                'Authorization' => 'Bearer ' . config('clients.genius.api_key'),
                'Content-Type'  => 'application/json',
            ]
        ]);
    }

    /**
     * @return ArtistResource
     */
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
