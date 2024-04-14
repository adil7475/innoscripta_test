<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\Baseline\BaselineRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserRepository extends BaselineRepository
{
    /**
     * Define repository's model
     *
     * @return string
     */
    public function model()
    {
        return User::class;
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
}
