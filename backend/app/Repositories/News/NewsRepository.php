<?php

namespace App\Repositories\News;

use App\Enums\CommonEnum;
use App\Http\Filters\News\NewsFilter;
use App\Http\Resources\News\NewsResource;
use App\Models\News;
use App\Repositories\Baseline\BaselineRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsRepository extends BaselineRepository
{
    protected $pagination = CommonEnum::DEFAULT_PAGINATION;

    /**
     * Define repository's model
     *
     * @return string
     */
    public function model(): string
    {
        return News::class;
    }

    /**
     * Return list of articles
     *
     * @return ResourceCollection
     */
    public function indexResource(): ResourceCollection
    {
        return NewsResource::collection($this->getModelData(app(NewsFilter::class)));
    }
}
