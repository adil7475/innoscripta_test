<?php

namespace App\Services\Integrations;

use App\Adapter\NYTimesAdapter;
use App\Enums\NYTimesEnum;
use App\Jobs\SaveNewsJob;
use Illuminate\Support\Facades\Http;

class NYTimesService
{
    private NYTimesAdapter $adapter;

    private string $url;

    public function __construct(NYTimesAdapter $adapter)
    {
        $this->adapter = $adapter;
        $this->url = config('nytimes.api_url');
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

            $responseObject = $response->json();

            $data = $responseObject['response']['docs'];

            if (empty($data)) {
                $continue = false;
                break;
            }

            $formattedData = $this->adapter->formatResponse($data);
            SaveNewsJob::dispatch($formattedData);

            if ((int)floor($responseObject['response']['meta']['hits']) === $currentPage) {
                $continue = false;
                break;
            }
            $currentPage++;

            // temporary condition as API returns a large number of results
            if ($currentPage === 3) {
                $continue = false;
                break;
            }
            sleep(NYTimesEnum::SLEEP_TIME);
        }
    }
}
