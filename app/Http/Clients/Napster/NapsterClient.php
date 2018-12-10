<?php

namespace App\Http\Clients\Napster;

use GuzzleHttp\Client;

class NapsterClient
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
     * @var string
     */
    public $url;

    /**
     * NapsterClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client([
            'base_uri' => config('clients.napster.api_url'),
            'headers' => [
                'apikey' => config('clients.napster.api_key'),
            ]
        ]);
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
