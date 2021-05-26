<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Contracts\ManagerDivisionRepository;
/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentManagerDivisionRepository extends EloquentBaseRepository implements ManagerDivisionRepository
{
    public function getManager($id)
    {
        $manager = $this->model::where('division_id','=',$id)->get();

        return $manager;
    }

    public function getDivision($id) 
    {
        $division = $this->model::where('user_id','=',$id)->get();

        return $division;
    }
}