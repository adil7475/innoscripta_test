<?php

namespace App\Services\Integrations;

use App\Adapter\NewsOrgAdapter;
use App\Enums\NewsOrgAPIEnum;
use App\Jobs\SaveNewsJob;
use Illuminate\Support\Facades\Http;

class NewsOrgService
{
    private NewsOrgAdapter $adapter;
    private string $url;

    public function __construct(NewsOrgAdapter $adapter)
    {
        $this->adapter = $adapter;
        $this->url = config('news_org.api_url');
    }

    public function sync(): void
    {
        $currentPage = 1;
        $continue = true;

        while ($continue) {
            $response = Http::get(
                $this->url,
                $this->adapter->formatRequest($currentPage)
            );
            if ($response->failed()) {
                $continue = false;
                break;
            }

            $data = $response->json('articles');
            $totalResults = $response->json('totalResults');

            if (empty($data)) {
                $continue = false;
                break;
            }

            $formattedData = $this->adapter->formatResponse($data);
            //Dispatch data to save news job to save the news
            SaveNewsJob::dispatch($formattedData);

            if (ceil($totalResults / NewsOrgAPIEnum::DEFAULT_PER_PAGE) >= $currentPage) {
                $continue = false;
                break;
            }

            // temporary condition as News API returns millions of results
            if ($currentPage == 1) {
                $continue = false;
                break;
            }

            $currentPage++;
        }
    }
}