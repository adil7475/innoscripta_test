<?php

namespace App\Services\Integrations;

use App\Adapter\NewsOrgAdapter;
use App\Enums\NewsOrgAPIEnum;
use App\Jobs\SaveNewsJob;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;

class NewsOrgService
{
    /**
     * @var NewsOrgAdapter
     */
    private NewsOrgAdapter $adapter;

    /**
     * @var string|Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    private string $url;

    /**
     * @param NewsOrgAdapter $adapter
     */
    public function __construct(NewsOrgAdapter $adapter)
    {
        $this->adapter = $adapter;
        $this->url = config('news_org.api_url');
    }

    /**
     * @return void
     */
    public function sync(): void
    {
        /**
         * As API Return a lot of pages so we are only getting data from first pages
         * If we want to get data from all pages then we can do it with loop
         */
        $response = Http::get(
            $this->url,
            $this->adapter->formatRequest(1)
        );
        if ($response->failed()) {
            /**
             * TODO::Need to notify use why api call not successful
             */
            return;
        }

        $data = $response->json('articles');

        if (empty($data)) {
            return;
        }

        $formattedData = $this->adapter->formatResponse($data);
        //Dispatch data to save news job to save the news
        SaveNewsJob::dispatch($formattedData);
    }
}
