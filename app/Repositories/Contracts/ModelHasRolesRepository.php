<?php

namespace App\Repositories\Contracts;

/**
 * UserRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface ModelHasRolesRepository extends BaseRepository
{
    public function getUserId($column,$data);
}
