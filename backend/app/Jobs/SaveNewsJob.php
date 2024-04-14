<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use App\Services\News\NewsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveNewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data =  $data;
        $this->onQueue(QueueEnum::SAVE_NEWS);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app(NewsService::class)->save($this->data);
    }
}
