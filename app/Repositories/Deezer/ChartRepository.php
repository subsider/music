<?php

namespace App\Repositories\Deezer;

use App\Models\Music\Chart;

class ChartRepository
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
     * @var Chart
     */
    private $chart;

    /**
     * ChartRepository constructor.
     * @param Chart $chart
     */
    public function __construct(Chart $chart)
    {
        $this->chart = $chart;
    }

    /**
     * @param Chart $chart
     * @param array $attributes
     */
    public function addImages(Chart $chart, array $attributes)
    {
        foreach ($attributes as $type => $src) {
            $chart->images()->updateOrCreate([
                'provider_id'   => config('clients.bandsintown.id'),
                'image_type_id' => $this->types[$type],
            ], [
                'src' => $src
            ]);
        }
    }
}
