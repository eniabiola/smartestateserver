<?php

namespace App\Repositories;

use App\Models\Estate;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSearchable();

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make Model instance
     *
     * @throws \Exception
     *
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'])
    {
        $query = $this->allQuery();

        return $query->paginate($perPage, $columns);
    }

    public function paginateViewBasedOnRole($perPage, $columns = ['*'], $search, $estate_id)
    {
        $query = $this->model->newQuery();
        $table = $this->model->getTable();
        $isColExist = Schema::hasColumn($table,'user_id');
        if (Auth::user()->hasrole('superadministrator'))
        {
            if ($estate_id == null)
            {
                $estate_id = Estate::query()->distinct()->first()->id;
            }
        } else {
            $estate_id = \request()->user()->estate_id;
        }

        $query->where(function($quer) use($estate_id){
           $quer->where('estate_id', $estate_id);
        })
            ->when(Auth::user()->hasRole('resident'), function ($query) use($isColExist){
                $query->when($isColExist, function ($query){
                   $query->where('user_id', Auth::id());
                });
            })
            ->orderBy('created_at', 'DESC');

//        $query = $this->searchFields($query, $search);
        return $query->paginate($perPage, $columns);
    }

    public function builderBasedOnRole($estate_column_name,$estate_id)
    {
        $query = $this->model->newQuery();
        $table = $this->model->getTable();
        $isColExist = Schema::hasColumn($table,'user_id');
        if (Auth::user()->hasrole('superadministrator'))
        {
            if ($estate_id == null)
            {
                $estate_id = Estate::query()->distinct()->first()->id;
            }
        } else {
            $estate_id = \request()->user()->estate_id;
        }

        $query->where(function($quer) use($estate_id, $estate_column_name){
            $quer->where($estate_column_name, $estate_id);
        })
            ->when(Auth::user()->hasRole('resident'), function ($query) use($isColExist){
                $query->when($isColExist, function ($query){
                    $query->where('user_id', Auth::id());
                });
            })
            ->orderBy('created_at', 'DESC');
            return $query;
    }

    public function paginateViewBasedOnUser($perPage, $columns = ['*'], $search, $estate_id, $user_id)
    {
        $query = $this->model->newQuery();
        $table = $this->model->getTable();
        $isColExist = Schema::hasColumn($table,'user_id');
        if (Auth::user()->hasrole('superadministrator'))
        {
            if ($estate_id == null)
            {
                $estate_id = Estate::query()->distinct()->first()->id;
            }
        } else {
            $estate_id = \request()->user()->estate_id;
        }

        $query->where(function($quer) use($estate_id){
           $quer->where('estate_id', $estate_id);
        })
            ->when($isColExist, function ($query) use($user_id){
                   $query->where('user_id', $user_id);
                })
            ->orderBy('created_at', 'DESC');

//        $query = $this->searchFields($query, $search);
        return $query->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Toggle Status of a model
     *
     */
    public function toggleStatus($id)
    {
        $query = $this->model->newQuery();

        $query =  $query->find($id);
        $query->isActive = !$query->isActive;
        $query->save();

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }


    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function allWithEstate($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $model = $this->model->newInstance($input);

        $model->save();

        return $model;
    }

    /**
     * Find model record for given id
     *
     * @param int $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id
     *
     * @param array $input
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     *
     * @throws \Exception
     *
     * @return bool|mixed|null
     */
    public function delete($id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }

    public function searchFields(Builder $query, $search_term)
    {
        $search = $this->getDataTableSearchParams($search_term);
        if (count($search)) {
            foreach($search as $key => $value) {
                \Log::debug($key." ! ".$value);
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, 'LIKE', '%'.$value.'%');
                }
            }
        }
        return $query;
    }

    /**
     * Get all columns in the table
     */
    public function getTableColumns()
    {
        $tableColumns = $this->model->getTable();
        return Schema::getColumnListing($tableColumns);
    }

    /**
     * @param array $processedRequest
     * @param $search_request
     * @return array
     */
    public function getDataTableSearchParams(array $processedRequest, $search_request): array
    {
        $search = [];
        if (!empty($processedRequest['search'])) {
            collect($this->getFieldsSearchable())->each(function ($field) use (&$search, $search_request) {
                $search[$field] = $search_request;
            });
        }
        return $search;
    }
}
