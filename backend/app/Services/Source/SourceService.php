<?php

namespace App\Services\Source;

use App\Repositories\News\SourceRepository;
use App\Services\Baseline\BaselineService;

class SourceService extends BaselineService
{
    public function __construct(SourceRepository $repository)
    {
        parent::__construct($repository);
    }
}
