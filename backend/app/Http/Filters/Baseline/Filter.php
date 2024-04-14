<?php

namespace App\Http\Filters\Baseline;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

abstract class Filter
{
    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * The builder instance.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Initialize a new filter instance.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters on the builder.
     *
     * @param  Builder  $builder
     * @return Builder
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
        foreach ($this->request->all() as $name => $value) {
            $name = Str::camel($name);

            $param = array_filter([$value], function ($value) {
                return $value !== null && $value !== false && $value !== '';
            });

            if (method_exists($this, $name) && $param) {
                call_user_func_array(
                    [$this, $name],
                    $param
                );
            }
        }

        return $this->builder;
    }

    /**
     * Sort the model by the given order and field.
     *
     * @param    $value
     * @return Builder
     */
    public function sort($value = [])
    {
        if (is_array($value)) {
            if (isset($value['by']) && ! Schema::hasColumn($this->builder->getModel()->getTable(), $value['by'])) {
                return $this->builder;
            }

            return $this->builder->orderBy(
                $value['by'] ?? 'created_at', $value['order'] ?? 'desc'
            );
        }

        return $this->builder;
    }
}
