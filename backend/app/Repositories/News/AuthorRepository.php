<?php

namespace App\Repositories\News;

use App\Enums\CommonEnum;
use App\Http\Filters\News\AuthorFilter;
use App\Http\Resources\News\SourceResource;
use App\Models\Author;
use App\Repositories\Baseline\BaselineRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthorRepository extends BaselineRepository
{
    protected $pagination = CommonEnum::DEFAULT_PAGINATION;

    /**
     * Define repository's model
     *
     * @return string
     */
    public function model(): string
    {
        return Author::class;
    }

    /**
     * Return list of authors
     *
     * @return ResourceCollection
     */
    public function indexResource(): ResourceCollection
    {
        return SourceResource::collection($this->getModelData(app(AuthorFilter::class)));
    }

    /**
     * Fetch authors by IDs
     *
     * @param  array  $ids
     * @return Collection
     */
    public function fetchByIDs(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}
