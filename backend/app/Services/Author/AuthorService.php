<?php

namespace App\Services\Author;

use App\Repositories\News\AuthorRepository;
use App\Services\Baseline\BaselineService;

class AuthorService extends BaselineService
{
    public function __construct(AuthorRepository $repository)
    {
        parent::__construct($repository);
    }
}
