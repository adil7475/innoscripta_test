<?php

namespace App\Services\Baseline;

use App\Repositories\Baseline\BaselineRepository;

class BaselineService
{
    protected $repository;

    public $relations = [];

    public $pagination;

    public function __construct(BaselineRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function index()
    {
        return $this->repository->with($this->relations)->index();
    }

    public function show($id)
    {
        return $this->repository->show($id);
    }

    public function store($data)
    {
        return $this->repository->create($data, false);
    }

    public function update($data, $id, $resource = true)
    {
        return $this->repository->update($data, $id, false, $resource);
    }

    public function setResource($resource)
    {
        $this->repository->setResource($resource);
    }

    public function setRelations($relations = [])
    {
        $this->repository->setRelations($relations);
    }

    public function setPagination($pagination = 20)
    {
        $this->repository->setPagination($pagination);
    }
}
