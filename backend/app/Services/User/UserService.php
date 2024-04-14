<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\Users\UserRepository;
use App\Services\Baseline\BaselineService;

class UserService extends BaselineService
{
    private UserSettingService $userSettingService;

    public function __construct(UserRepository $repository, UserSettingService $userSettingService)
    {
        parent::__construct($repository);
        $this->userSettingService = $userSettingService;
    }

    public function store($data): User
    {
        $user = $this->repository->create($data);
        $this->userSettingService->store([
            'user_id' => $user->id,
            'categories' => [],
            'sources' => [],
            'authors' => []
        ]);
        $user->refresh();
        return $user;
    }
}
