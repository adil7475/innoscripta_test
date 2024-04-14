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
            sleep(5);
        }
    }
}
