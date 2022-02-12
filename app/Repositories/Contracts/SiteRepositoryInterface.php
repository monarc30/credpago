<?php

namespace App\Repositories\Contracts;

interface SiteRepositoryInterface 
{
    public function all();

    public function find($id);    

    public function create($data);

    public function orderBy($data);

    public function where($data);
}