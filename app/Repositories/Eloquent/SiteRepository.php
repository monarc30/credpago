<?php

namespace App\Repositories\Eloquent;

use App\Models\Site;
use App\Repositories\Contracts\SiteRepositoryInterface;

class SiteRepository extends AbstractRepository implements SiteRepositoryInterface
{
    
    protected $model = Site::class;       
    
}   