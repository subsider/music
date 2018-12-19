<?php

namespace App\Http\Clients\Lastfm;

use GuzzleHttp\Client;

class LastfmClient
{
    const MAX_LIMIT = 1000;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    public $params;

    /**
     * LastfmClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->params = [
            'api_key' => config('clients.lastfm.api_key'),
            'format'  => 'json'
        ];
    }

    /**
     * @return ArtistResource
     */
    public function artist()
    {
        return new ArtistResource($this);
    }

    /**
     * @param int $page
     * @return $this
     */
    public function page(int $page)
    {
        $this->params = array_merge([
            'page' => $page,
        ], $this->params);

        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit = self::MAX_LIMIT)
    {
        $this->params = array_merge([
            'limit' => $limit,
        ], $this->params);

        return $this;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get()
    {
        $response = $this->client->request('GET', config('clients.lastfm.api_url'), [
            'form_params' => $this->params,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
