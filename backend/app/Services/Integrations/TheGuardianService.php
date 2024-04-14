<?php

namespace App\Services\Integrations;

use App\Adapter\TheGuardianAdapter;
use App\Enums\NewsOrgAPIEnum;
use App\Jobs\SaveNewsJob;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;

class TheGuardianService
{
    /**
     * @var TheGuardianAdapter
     */
    private TheGuardianAdapter $adapter;

    /**
     * @var string|Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    private string $url;

    /**
     * @param TheGuardianAdapter $theGuardianAdapter
     */
    public function __construct(TheGuardianAdapter $theGuardianAdapter)
    {
        $this->adapter = $theGuardianAdapter;
        $this->url = config('guardian.api_url');
    }

    /**
     * @return void
     */
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
            $responseObject = $response->json('response');
            $data = $responseObject['results'];
            $totalResults = $responseObject['total'];

            if (empty($data)) {
                $continue = false;
                break;
            }
            $formattedData = $this->adapter->formatResponse($data);

            //Dispatch data to save news job to save the news
            SaveNewsJob::dispatch($formattedData);

            if (ceil($totalResults / 100) >= $currentPage) {
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
