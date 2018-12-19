<?php

namespace App\Console\Commands\Deezer\Artist;

use App\Exceptions\ArtistNotFoundException;
use App\Models\Provider\Service;
use Illuminate\Console\Command;
use App\Models\Util\Command as CommandModel;
use Illuminate\Support\Facades\Artisan;

class ArtistBatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deezer:artist:batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lastCrawled = CommandModel::whereSignature($this->signature)
            ->latest('last_crawled_id')
            ->first();

        $lastCrawledId = $lastCrawled->last_crawled_id;

        for ($i = 1; $i <= 100; $i++) {
            $this->info($lastCrawled->last_crawled_id);

            try {
                Artisan::call('deezer:artist:info', ['id' => $lastCrawledId]);
                Artisan::call('deezer:artist:albums', ['id' => $lastCrawledId]);
                Artisan::call('deezer:artist:tracks', ['id' => $lastCrawledId]);
                Artisan::call('deezer:artist:related', ['id' => $lastCrawledId]);
                Artisan::call('deezer:artist:radio', ['id' => $lastCrawledId]);
                Artisan::call('deezer:artist:fans', ['id' => $lastCrawledId]);
                Artisan::call('deezer:artist:comments', ['id' => $lastCrawledId]);
            } catch (ArtistNotFoundException $e) {
                $this->warn($e->getMessage());
            }

            $service = Service::where([
                'provider_id' => config('clients.deezer.id'),
                'internal_id' => $lastCrawledId,
                'model_type'  => 'App\Models\Music\Artist',
            ])->first();

            if ($service) {
                $service->update(['crawled_at' => now()]);
            }

            $lastCrawledId++;

            $lastCrawled->update([
                'last_crawled_id' => $lastCrawledId,
                'crawled_at'      => now(),
            ]);
        }
    }
}
