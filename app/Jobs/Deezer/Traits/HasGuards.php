<?php

namespace App\Jobs\Deezer\Traits;

use App\Models\Music\Album;
use App\Models\Music\Artist;
use App\Models\Provider\Service;

trait HasGuards
{
    /**
     * @return mixed
     */
    private function guardAgainstNullArtist()
    {
        $service = Service::where([
            'internal_id' => $this->id,
            'model_type' => 'App\Models\Music\Artist',
            'provider_id' => config('clients.deezer.id'),
        ])->first();

        if (! $service) {
            dump('Service not available. ' . $this->id);
            exit;
        }

        return Artist::find($service->model_id);
    }

    /**
     * @return mixed
     */
    private function guardAgainstNullAlbum()
    {
        $service = Service::where([
            'internal_id' => $this->id,
            'model_type' => 'App\Models\Music\Album',
            'provider_id' => config('clients.deezer.id'),
        ])->first();

        if (! $service) {
            dump('Service not available. ' . $this->id);
            exit;
        }

        return Album::find($service->model_id);
    }
}
