<?php

namespace App\Repositories\News;

use App\Enums\CommonEnum;
use App\Http\Filters\News\SourceFilter;
use App\Http\Resources\News\AuthorResource;
use App\Models\Source;
use App\Repositories\Baseline\BaselineRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SourceRepository extends BaselineRepository
{
    protected $pagination = CommonEnum::DEFAULT_PAGINATION;

    /**
     * Define repository's model
     *
     * @return string
     */
    public function model(): string
    {
        return Source::class;
    }

    /**
     * Return list of sources
     *
     * @return ResourceCollection
     */
    public function indexResource(): ResourceCollection
    {
        return AuthorResource::collection($this->getModelData(app(SourceFilter::class)));
    }

    /**
     * Fetch sources by IDs
     *
     * @param  array  $ids
     * @return Collection
     */
    public function fetchByIDs(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}
