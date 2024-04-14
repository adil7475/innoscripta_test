<?php

namespace App\Http\Filters\News;

use App\Http\Filters\Baseline\Filter as BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class AuthorFilter extends BaseFilter
{
    /**
     * Search with keyword
     *
     * @param  string|null  $value
     * @return Builder
     */
    public function name(string $value = null): Builder
    {
        return $this->builder->where('name', 'like', $value . '%');
    }
}
