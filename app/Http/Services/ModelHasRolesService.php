<?php

namespace App\Http\Services;


use App\Repositories\Contracts\ModelHasRolesRepository;

class ModelHasRolesService
{
    public $modelRoleRepository;

    public function __construct(ModelHasRolesRepository $modelRoleRepository)
    {
        $this->modelRoleRepository = $modelRoleRepository;
    }

    public function getUserId($column1,$data)
    {
        $result = $this->modelRoleRepository->getUserId($column1,$data);

        return $result;
    }

}
