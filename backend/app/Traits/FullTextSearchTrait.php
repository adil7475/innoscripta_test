<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FullTextSearchTrait
{
    public function scopeFullText(Builder $query, array $columns, string $value): Builder
    {
        return $query->when('sqlite' === getenv('DB_CONNECTION'), function ($q) use ($columns, $value) {
            $q->where(function ($query) use ($columns, $value) {
                foreach ($columns as $column) {
                    $query->OrWhere($column, 'LIKE', '%'.$value.'%');
                }
            });
        }, function ($q) use ($columns, $value) {
            $q->where(function ($query) use ($columns, $value) {
                foreach ($columns as $column) {
                    $query->OrWhereFullText($column, "*$value*", ['mode' => 'boolean']);
                }
            });
        });
    }
}
