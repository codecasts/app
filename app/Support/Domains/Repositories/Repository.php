<?php

namespace Codecasts\Support\Domains\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Jenssegers\Mongodb\Eloquent\Builder as MongoBuilder;
use Codecasts\Support\Domains\Model as EloquentModel;
use Illuminate\Pagination\AbstractPaginator;

/**
 * Class Repository
 * 
 * Base Repository implementation.
 */
abstract class Repository
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $modelClass;

    /**
     * @var int
     */
    protected $maxLimit = 100;

    /**
     * @var array|null Eager loading overwrites.
     */
    protected $with = null;

    /**
     * @return DatabaseManager
     */
    public function db()
    {
        // return the database manager resolved from the container.
        return resolve(DatabaseManager::class);
    }

    /**
     * Create a new database query.
     *
     * @return MongoBuilder
     */
    public function newQuery()
    {
        /** @var MongoBuilder $query */
        $query = app()->make($this->modelClass)->newQuery();

        // eager-loading.
        if ($this->with && is_array($this->with)) {
            $query->with($this->with);
        }

        // return query instance.
        return $query;
    }

    /**
     * Execute a query against the database.
     *
     * @param MongoBuilder $query      Query instance, if a previous one was passed as parameters.
     * @param int          $take       Limit on the results..
     * @param bool         $paginate   Indicate paginated results or not.
     *
     * @return EloquentCollection|LengthAwarePaginator|AbstractPaginator
     */
    public function doQuery($query = null, $take = 15, $paginate = true)
    {
        // create a new query or use the provided.
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        // when pagination is request, return calling paginate.
        if (true == $paginate) {
            return $query->paginate($take);
        }

        // if a given take limit was provided, and it's not invalid integer.
        if ($take > 0 || false !== $take) {
            // limit the query, but considering the safe limit on the repository settings.
            $query->take($take > $this->maxLimit ? $this->maxLimit : $take);
        }

        // otherwise get it all!
        return $query->get();
    }

    /**
     * Creates a Model object with the $data information.
     *
     * @param array $data
     *
     * @return EloquentModel
     */
    public function factory(array $data = [])
    {
        // factory an empty model.
        /** @var EloquentModel $model */
        $model = $this->newQuery()->getModel()->newInstance();

        // fill data.
        $this->setModelData($model, $data);

        // return the model, but without saving.
        return $model;
    }

    /**
     * Performs the save method of the model
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param EloquentModel $model
     *
     * @return bool
     */
    public function save($model)
    {
        return $model->save();
    }

    /**
     * Create a record, using a data array as source.
     * 
     * @param array $data
     *
     * @return EloquentModel
     */
    public function create(array $data = [])
    {
        // factory model instance.
        $model = $this->factory($data);

        // save the record.
        $this->save($model);

        // return the saved model.
        return $model;
    }

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int  $take
     * @param bool $paginate
     *
     * @return MongoBuilder|AbstractPaginator|LengthAwarePaginator
     */
    public function getAll($take = 15, $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * @param string      $column
     * @param string|null $key
     *
     * @return SupportCollection
     */
    public function pluck($column, $key = null)
    {
        return $this->newQuery()->pluck($column, $key);
    }

    /**
     * @param int $id
     * @param bool $fail
     *
     * @return EloquentModel|Model|null
     */
    public function findByID($id, $fail = false)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }

    /**
     * Updated model data, using $data
     * The sequence performs the Model update.
     *
     * @param EloquentModel $model
     * @param array                               $data
     *
     * @return bool
     */
    public function update($model, array $data = [])
    {
        $this->setModelData($model, $data);

        return $this->save($model);
    }
    
    /**
     * Run the delete command model.
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param EloquentModel $model
     * @param bool $force
     *
     * @return bool
     * 
     * @throws 
     */
    public function delete($model, $force = false)
    {
        if ($force) {
            return $model->forceDelete();
        }

        return $model->delete();
    }

    /**
     * Run the delete command model.
     *
     * @param EloquentCollection $collection
     *
     * @return bool
     */
    public function deleteAll($collection)
    {
        $collection->each(function (EloquentModel $item) {
            $item->delete();
        });
        
        return true;
    }

    /**
     * @param array|null $relations
     *
     * @return $this
     */
    public function with(array $relations = null)
    {
        $this->with = $relations;

        return $this;
    }

    /**
     * @param EloquentModel  $model
     * @param array          $data
     *
     * @return EloquentModel
     */
    protected function setModelData($model, array $data)
    {
        return $model->fill($data);
    }
}
