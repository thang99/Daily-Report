<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ModelHasRolesRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;


/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentModelHasRolesRepository extends EloquentBaseRepository implements ModelHasRolesRepository
{
    public function getUserId($column,$data)
    {
       $user_id = $this->model::select('model_id')->whereIn($column,$data)->get();

       return $user_id;
    }

      
}
