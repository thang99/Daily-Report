<?php

namespace App\Repositories\Contracts;

/**
 * UserRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface UserDivisionRepository extends BaseRepository
{
    public function getUserByDivision($search);
    public function searchUserByDivision($search);
    
}
