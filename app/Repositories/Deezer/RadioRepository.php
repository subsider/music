<?php

namespace App\Repositories\Deezer;

use App\Models\Music\Radio;

class RadioRepository
{
    /**
     * @var array
     */
    protected $types = [
        'avatar'  => 2,
        'cover'   => 4,
        'picture' => 5,
        'large'   => 6,
    ];

    /**
     * @var Radio
     */
    private $radio;

    /**
     * ChartRepository constructor.
     * @param Radio $radio
     */
    public function __construct(Radio $radio)
    {
        $this->radio = $radio;
    }

    public function create(array $attributes, $type = Radio::TRACK)
    {
        $radio = $this->radio->updateOrCreate([
            'radio_type_id' => $type,
            'provider_id'   => config('clients.deezer.id'),
            'name'          => $attributes['title'],
            'internal_id'   => $attributes['id'],
        ]);

        return $radio;
    }

    /**
     * @param Radio $radio
     * @param array $attributes
     */
    public function addImages(Radio $radio, array $attributes)
    {
        foreach ($attributes as $type => $src) {
            $radio->images()->updateOrCreate([
                'provider_id'   => config('clients.bandsintown.id'),
                'image_type_id' => $this->types[$type],
            ], [
                'src' => $src
            ]);
        }
    }
}
