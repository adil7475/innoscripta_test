<?php

namespace App\Console\Commands;

use App\Jobs\SyncIntegrationsJob;
use Illuminate\Console\Command;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is use for fetching news from different news integrations';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
       $integrations = config('integrations.integrations.integrations');
       foreach ($integrations as $name => $config) {
            if ($config['active']) {
                SyncIntegrationsJob::dispatch($name);
            }
       }

       return Command::SUCCESS;
    }
}
