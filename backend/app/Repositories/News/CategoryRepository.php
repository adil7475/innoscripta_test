<?php

namespace App\Repositories\News;

use App\Enums\CommonEnum;
use App\Http\Filters\News\CategoryFilter;
use App\Http\Resources\News\CategoryResource;
use App\Models\Category;
use App\Repositories\Baseline\BaselineRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryRepository extends BaselineRepository
{
    protected $pagination = CommonEnum::DEFAULT_PAGINATION;

    /**
     * Define repository's model
     *
     * @return string
     */
    public function model(): string
    {
        return Category::class;
    }

    /**
     * Return list of categories
     *
     * @return ResourceCollection
     */
    public function indexResource(): ResourceCollection
    {
        return CategoryResource::collection($this->getModelData(app(CategoryFilter::class)));
    }

    /**
     * Fetch categories by IDs
     *
     * @param  array  $ids
     * @return Collection
     */
    public function fetchByIDs(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}
