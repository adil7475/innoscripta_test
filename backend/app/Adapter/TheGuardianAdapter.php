<?php

namespace App\Adapter;


use App\Adapter\Baseline\NewsAdapterInterface;
use Carbon\Carbon;

class TheGuardianAdapter implements NewsAdapterInterface
{
    public function formatRequest(int $page): array
    {
        return [
            'api-key' => config('guardian.api_key'),
            'from-date' => Carbon::yesterday()->format('Y-m-d'),
            'to-date' => Carbon::today()->format('Y-m-d'),
            'page' => $page,
            'page-size' => 100,
            'show-fields' => 'headline'
        ];
    }

    public function formatResponse(array $data): array
    {
        $formattedData = [];
        foreach ($data as $newsFeed) {
            $formattedData[] = [
                'article' => [
                    'title' => $newsFeed['webTitle'],
                    'description' => $newsFeed['fields']['headline'],
                    'published_at' => Carbon::parse($newsFeed['webPublicationDate']),
                ],
                'source' => [
                    'name' => 'The Guardian',
                ],
                'category' => [
                    'name' => $newsFeed['sectionName'],
                ],
                'author' => null,
            ];
        }
        return $formattedData;
    }
}
