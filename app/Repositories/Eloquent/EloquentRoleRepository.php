<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RoleRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;

/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentRoleRepository extends EloquentBaseRepository implements RoleRepository
{
    public function getRoleId($column,$data1,$data2)
    {
        $id = $this->model::select('id')->where($column,'=',$data1)->orWhere($column,'=',$data2)->get();

        return $id;        
    }
}
