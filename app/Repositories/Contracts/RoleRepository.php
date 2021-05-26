<?php

namespace App\Repositories\Contracts;

/**
 * RoleRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface RoleRepository extends BaseRepository
{
    public function getRoleId($column,$data1,$data2);
}
