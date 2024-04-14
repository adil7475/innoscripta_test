<?php

namespace App\Adapter;

use App\Adapter\Baseline\NewsAdapterInterface;
use Carbon\Carbon;

class NYTimesAdapter implements NewsAdapterInterface
{
    public function formatRequest(int $page): array
    {
        return [
            'api-key' => config('nytimes.api_key'),
            'from-date' => str_replace('-', '', Carbon::yesterday()->format('Y-m-d')),
            'to-date' => str_replace('-', '', Carbon::today()->format('Y-m-d')),
            'page' => $page,
            'sort' => 'newest'
        ];
    }

    public function formatResponse(array $data): array
    {
        $formattedData = [];

        foreach ($data as $newsFeed) {
            $formattedData[] = [
                'article' => [
                    'title' => $newsFeed['headline']['main'],
                    'description' => $newsFeed['lead_paragraph'],
                    'published_at' => Carbon::parse($newsFeed['pub_date']),
                ],
                'source' => [
                    'name' => $newsFeed['source']
                ],
                'category' => [
                    'name' => $newsFeed['section_name']
                ],
                'author' => $newsFeed['byline']['original'] ?
                    ['name' => substr($newsFeed['byline']['original'], 3)] :
                    null
            ];
        }

        return $formattedData;
    }
}
