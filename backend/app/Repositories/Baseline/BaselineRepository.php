<?php

namespace App\Repositories\Baseline;

use App\Exceptions\RepositoryException;
use App\Http\Filters\Baseline\Filter;
use Illuminate\Container\Container as App;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
abstract class BaselineRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $boot;

    private $app;

    /**
     * @var array
     */
    protected $relations;

    /**
     * @var JsonResource | ResourceCollection
     */
    protected $resource;

    /**
     * @var int
     */
    protected $pagination;

    /**
     * @param  App  $app
     *
     * @throws RepositoryException
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->cleanRepository();
    }

    /**
     * Set resource used in wrapping data
     *
     * @param $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Set relations needed to be eager loaded
     *
     * @param $relations
     */
    public function setRelations($relations)
    {
        $this->relations = $relations;
    }

    /**
     * Set pagination count
     *
     * @param $pagination
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws RepositoryException
     */
    public function index()
    {
        $resource = $this->indexResource();
        $this->cleanRepository();

        return $resource;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function indexResource()
    {
        return $this->resource::collection($this->getModelData());
    }

    /**
     * @param $data
     * @return mixed
     */
    public function wrapData($data)
    {
        return $this->resource ? new $this->resource($data) : $data;
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function filter($filter)
    {
        return $this->model->filter($filter);
    }

    /**
     * @param Filter|null $filter
     * @return mixed
     */
    public function getModelData(Filter $filter = null)
    {
        $model = $filter ? $this->filter($filter) : $this->model;

        if ($this->relations) {
            $model->with($this->relations);
        }

        return $this->pagination ? $model->paginate($this->pagination) : $model->get();
    }

    /**
     * @param $id
     * @return mixed
     * @throws RepositoryException
     */
    public function show($id)
    {
        $model = $this;

        if ($this->relations) {
            $model = $model->with($this->relations);
        }

        $model = $model->find($id);

        $resource = $this->wrapData($model);
        $this->cleanRepository();

        return $resource;
    }

    /**
     * @return JsonResource|ResourceCollection
     * @throws RepositoryException
     */
    public function makeResource()
    {
        if ($this->resource) {
            if (
                !is_subclass_of($this->resource, 'Illuminate\Http\Resources\Json\ResourceCollection') &&
                !is_subclass_of($this->resource, 'Illuminate\Http\Resources\Json\JsonResource')
            ) {
                throw new RepositoryException("Class {$this->resource} must be an instance of Illuminate\\Http\\Resources\\Json\\ResourceCollection or
            Illuminate\Http\Resources\Json\JsonResource");
            }
        }

        return $this->resource;
    }

    /**
     * @param array $data
     * @param $force
     * @param $resource
     * @return mixed
     * @throws RepositoryException
     */
    public function create(array $data, $force = true, $resource = true)
    {
        $model = $force ? $this->model->forceCreate($data) : $this->model->create($data);
        $resource = $resource && $this->resource ? new $this->resource($model) : $model;
        $this->cleanRepository();

        return $resource;
    }

    /**
     * @param array $data
     * @param int|null $id
     * @param bool $force
     * @param bool $resource
     * @return mixed
     * @throws RepositoryException
     */
    public function update(array $data, int $id = null, bool $force = true, bool $resource = true)
    {
        if (is_null($id) and $this->model instanceof Builder) {
            $object = $this->first();
            $model = $object;
        } else {
            $object = $this->find($id);
            $model = $object;
        }

        $model = $force ? $model->forceFill($data)->save() : $model->update($data);
        $resource = $resource && $this->resource ? new $this->resource($model) : $object->fresh();
        $this->cleanRepository();

        return $resource;
    }

    /**
     * @throws RepositoryException
     */
    protected function cleanRepository()
    {
        $this->criteria = new Collection();
        $this->withBoot();
        $this->makeModel();
        $this->makeResource();
    }

    /**
     * @return $this
     */
    public function withBoot()
    {
        $this->boot = true;

        return $this;
    }

    /**
     * @return Model
     *
     * @throws RepositoryException
     * @throws BindingResolutionException
     */
    protected function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @return mixed
     */
    abstract public function model();

    /**
     * @param $attr
     * @param $value
     * @return mixed
     */
    public function updateOrCreate($attr, $value)
    {
        return $this->model->updateOrCreate($attr, $value);
    }

    /**
     * @param  array  $where
     * @param  string  $boolean
     * @return $this
     */
    public function where(array $where, $boolean = 'and')
    {
        foreach ($where as $k => $v) {
            [$field, $condition, $value] = is_array($v) ? $v : [$k, '=', $v];
            $this->model = $this->model->where($field, $condition, $value, $boolean);
        }

        return $this;
    }

    /**
     * @param  array  $columns
     * @param  bool  $fail
     * @return mixed
     *
     * @throws RepositoryException
     */
    public function first($columns = ['*'], $fail = true)
    {
        $method = $fail ? 'firstOrFail' : 'first';
        $result = $this->model->{$method}($columns);
        $this->cleanRepository();

        return $result;
    }

    /**
     * @param $id
     * @param  array  $columns
     * @param  bool  $fail
     * @return mixed
     *
     * @throws RepositoryException
     */
    public function find($id, $columns = ['*'], $fail = true)
    {
        $method = $fail ? 'findOrFail' : 'find';
        $result = $this->model->{$method}($id, $columns);
        $this->cleanRepository();

        return $result;
    }

    /**
     * @param  array|string  $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * @param array $data
     * @param array $columns
     * @return mixed
     */
    public function upsert(array $data, array $columns)
    {
        if (env('DB_CONNECTION') === 'sqlite') {
            return $this->model->insert($data);
        }

        return $this->model->upsert($data, $columns);
    }
}
