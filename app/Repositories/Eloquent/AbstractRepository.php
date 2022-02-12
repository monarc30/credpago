<?php

namespace App\Repositories\Eloquent;

abstract class AbstractRepository 
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    protected function resolveModel()
    {
        return app($this->model);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id) 
    {
        return $this->model->find($id);
    }

    public function create($data) 
    {
        return $this->model->create($data);
    }

    public function orderBy($data) 
    {
        return $this->model->orderBy($data);
    }

    public function where($data) 
    {
        return $this->model->where($data);
    }
}