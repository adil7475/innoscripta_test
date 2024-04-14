<?php

namespace app\Services\User;

use App\Repositories\Users\UserSettingRepository;
use App\Services\Baseline\BaselineService;

class UserSettingService extends BaselineService
{
    public function __construct(UserSettingRepository $repository)
    {
        parent::__construct($repository);
    }
}
