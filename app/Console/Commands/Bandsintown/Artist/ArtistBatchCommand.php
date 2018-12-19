<?php

namespace App\Console\Commands\Bandsintown\Artist;

use App\Models\Music\Artist;
use App\Models\Util\Command as CommandModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ArtistBatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bandsintown:artist:batch';

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

        for ($i = 1; $i <= 100; $lastCrawled->last_crawled_id++) {
            $artist = Artist::findOrFail($lastCrawled->last_crawled_id);
            $this->info('Find ' . $artist->name);
            $this->info('Crawling events for ' . $artist->name);
            Artisan::call('bandsintown:artist:info', ['artist' => $artist->name]);
            Artisan::call('bandsintown:artist:events', ['artist' => urlencode($artist->name)]);

            $service = $artist->services()
                ->where([
                    'provider_id' => config('clients.bandsintown.id'),
                    'model_id'    => $artist->id,
                    'model_type'  => get_class($artist)
                ])->first();

            if ($service) {
                $this->info('Find Service for ' . $artist->name);
                $service->update(['crawled_at' => now()]);
                $this->info('Mark service for ' . $artist->name . ' as crawled');
            }

            $lastCrawled->update([
                'last_crawled_id' => $artist->id,
                'crawled_at'      => now(),
            ]);
            $this->info('Last artist crawled ' . $lastCrawled->last_crawled_id);
        }
    }
}
