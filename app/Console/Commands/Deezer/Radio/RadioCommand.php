<?php

namespace App\Console\Commands\Deezer\Radio;

use App\Jobs\Deezer\Radio\ProcessRadio;
use Illuminate\Console\Command;

class RadioCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deezer:radio';

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
        ProcessRadio::dispatch();
    }
}
