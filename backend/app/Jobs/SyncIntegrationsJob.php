<?php

namespace App\Jobs;

use App\Services\Integrations\NewsOrgService;
use App\Services\Integrations\NYTimesService;
use App\Services\Integrations\TheGuardianService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncIntegrationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $integration;

    /**
     * Create a new job instance.
     */
    public function __construct(string $integration)
    {
        $this->integration = $integration;
        $this->onQueue('SYNC_INTEGRATIONS');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        switch ($this->integration) {
            case 'news_org':
                app(NewsOrgService::class)->sync();
                break;
            case 'the_guardian':
                app(TheGuardianService::class)->sync();
                break;
            case 'ny_times':
                app(NYTimesService::class)->sync();
                break;
        }
    }
}
