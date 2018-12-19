<?php

namespace App\Http\Clients\Deezer;

use GuzzleHttp\Client;

class DeezerClient
{
    const MAX_LIMIT = 50;

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
    public $query = [];

    /**
     * BandsintownClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client([
            'base_uri' => config('clients.deezer.api_url')
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
     * @return AlbumResource
     */
    public function album()
    {
        return new AlbumResource($this);
    }

    /**
     * @return TrackResource
     */
    public function track()
    {
        return new TrackResource($this);
    }

    /**
     * @return GenreResource
     */
    public function genre()
    {
        return new GenreResource($this);
    }

    /**
     * @return ChartResource
     */
    public function chart()
    {
        return new ChartResource($this);
    }

    /**
     * @return RadioResource
     */
    public function radio()
    {
        return new RadioResource($this);
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit = self::MAX_LIMIT)
    {
        $this->query = array_merge([
            'query' => [
                'limit' => $limit
            ],
        ], $this->query);

        return $this;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get()
    {
        $response = $this->client->request('GET', $this->url, $this->query);

        return json_decode($response->getBody()->getContents(), true);
    }
}
