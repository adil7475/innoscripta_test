<?php

namespace App\Services\User;

use App\Repositories\Users\UserRepository;
use App\Services\Baseline\BaselineService;

class UserService extends BaselineService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }
}
