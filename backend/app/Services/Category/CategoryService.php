<?php

namespace App\Services\Category;

use App\Repositories\News\CategoryRepository;
use App\Services\Baseline\BaselineService;

class CategoryService extends BaselineService
{
    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);
    }
}
