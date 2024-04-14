<?php

namespace App\Repositories\Users;

use App\Models\UserSetting;
use App\Repositories\Baseline\BaselineRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserSettingRepository extends BaselineRepository
{
    /**
     * Define repository's model
     *
     * @return string
     */
    public function model(): string
    {
        return UserSetting::class;
    }

    /**
     * Return list of sources
     *
     * @return ResourceCollection
     */
    public function indexResource(): ResourceCollection
    {
        return $this->resource::collection($this->getModelData());
    }

    /**
     * Update or create user's preferences
     *
     * @param  array  $data
     * @param  int|null  $id
     * @param  bool  $force
     * @param  bool  $resource
     * @return void
     */
    public function update(array $data, int $id = null, bool $force = true, bool $resource = true): void
    {
        $this->updateOrCreate(['user_id' => $id], array_merge($data, ['user_id' => $id]));
    }
}
