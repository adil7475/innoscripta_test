<?php

namespace App\Services\Integrations;

use App\Adapter\NYTimesAdapter;
use App\Enums\NYTimesEnum;
use App\Jobs\SaveNewsJob;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;

class NYTimesService
{
    /**
     * @var NYTimesAdapter
     */
    private NYTimesAdapter $adapter;

    /**
     * @var string|Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    private string $url;

    /**
     * @param NYTimesAdapter $adapter
     */
    public function __construct(NYTimesAdapter $adapter)
    {
        $this->adapter = $adapter;
        $this->url = config('nytimes.api_url');
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

        $responseObject = $response->json();

        $data = $responseObject['response']['docs'];

        if (empty($data)) {
            return;
        }

        $formattedData = $this->adapter->formatResponse($data);
        SaveNewsJob::dispatch($formattedData);
    }
}
