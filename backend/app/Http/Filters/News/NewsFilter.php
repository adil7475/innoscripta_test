<?php

namespace App\Http\Filters\News;

use App\Http\Filters\Baseline\Filter as BaseFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class NewsFilter extends BaseFilter
{
    /**
     * @param  string|null  $value
     * @return Builder
     */
    public function keyword(string $value = null): Builder
    {
        return $this->builder->fullText(['title', 'description'], $value);
    }

    /**
     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function publishedAt(string $value = null): \Illuminate\Database\Eloquent\Builder
    {
        return $this->builder->where('published_at', '>=', Carbon::createFromTimestamp($value)->toDateTimeString());
    }


    /**
     * @param array $value
     * @return Builder
     */
    public function sources(array $value = []): Builder
    {
        return $this->builder->whereIn('source_id', $value);
    }

    /**
     * Filter with specific categories
     *
     * @param array $value
     * @return Builder
     */
    public function categories(array $value = []): Builder
    {
        return $this->builder->whereIn('category_id', $value);
    }

    /**
     * Filter with specific authors
     *
     * @param array $value
     * @return Builder
     */
    public function authors(array $value = []): Builder
    {
        return $this->builder->whereIn('author_id', $value);
    }
}
