<?php

namespace App\Adapter;

use App\Adapter\Baseline\NewsAdapterInterface;
use Carbon\Carbon;

class NewsOrgAdapter implements NewsAdapterInterface
{
    public function formatRequest(int $page): array
    {
        return [
            'apiKey' => config('news_org.api_key'),
            'from_date' => Carbon::yesterday()->format('Y-m-d'),
            'to_date' => Carbon::today()->format('y-m-d'),
            'page' => $page,
            'q' => 'a' //As API always required this parameter
        ];
    }

    public function formatResponse(array $data): array
    {
        $formattedData = [];
        foreach ($data as $newFeed) {
            if (self::validateNewsFeed($newFeed)) {
                $formattedData[] = [
                    'article' => [
                        'title' => $newFeed['title'],
                        'description' => $newFeed['description'],
                        'published_at' => Carbon::parse($newFeed['publishedAt']),
                        'image_url' => $newFeed['urlToImage'],
                    ],
                    'author' => $newFeed['author'] ? [
                        'name' => self::formatAuthor($newFeed['author'])
                    ] : null,
                    'source' => [
                        'name' => $newFeed['source']['name']
                    ],
                    'category' => null
                ];
            }
        }

        return $formattedData;
    }

    private static function formatAuthor(?string $authors): ?string
    {
        if (is_null($authors)) return null;
        return explode(',', $authors)[0] ?? '';
    }

    private static function validateNewsFeed($newsFeed): bool
    {
        return $newsFeed['title'] !== "[Removed]";
    }
}
