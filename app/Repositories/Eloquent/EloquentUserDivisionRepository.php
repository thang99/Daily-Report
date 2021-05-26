<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserDivisionRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentUserDivisionRepository extends EloquentBaseRepository implements UserDivisionRepository
{
    public function getUserByDivision($search)
    {
        if($search != 'all')
        {
           return $this->searchUserByDivision($search);
        }

        $user = DB::table('users')->orderByDesc('users.created_at')->paginate(5);

        return $user;
    }

    public function searchUserByDivision($search)
    {
        $user = DB::table('divisions')
            ->select('divisions.name as name_division','users.*')
            ->join('position_division', 'position_division.division_id', '=', 'divisions.id')
            ->join('users', 'users.position_division_id', '=', 'position_division.id')
            ->where('divisions.id', '=', $search)->paginate(5);

        return $user;
    }
}
