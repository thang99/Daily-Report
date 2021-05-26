<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\FollowRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentFollowRepository extends EloquentBaseRepository implements FollowRepository
{
    /**
     * Get User Follow by user_id
     *
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getUsersFollow($userId)
    {

        $query = DB::table('follows')
            ->where('follows.by', '=', $userId)
            ->where('follows.status', '=', config('common.status_follow.on_follow'))
            ->where('follow_user.position_division_id', '!=', null)
            ->join('users as user_follow', 'user_follow.id', '=', 'follows.by')
            ->join('users as follow_user', 'follow_user.id', '=', 'follows.user_id')
            ->join('position_division', 'position_division.id', '=', 'follow_user.position_division_id')
            ->join('positions', 'positions.id', '=', 'position_division.position_id')
            ->join('divisions', 'divisions.id', '=', 'position_division.division_id')
            ->select('follow_user.name as follow_name', 'follows.status', 'positions.name as position_name',
                'divisions.name as division_name',
                'follows.user_id', 'follows.by as follow_id',
                'follows.id', 'follow_user.avatar');

        $result = $query->paginate(4);

        return $result;
    }

    public function storeFollowUser($user_id, $by, $status)
    {

        $checkUserFollow = self::checkUserFollow($user_id, $by);


        if ($checkUserFollow === config('common.status_follow.on_follow')) {


            $query = $this->model->where('user_id', '=', $user_id)->where('by', '=',
                $by)->update(['status' => $status]);

        } else {
            $data = ['user_id' => $user_id, 'by' => $by, 'status' => $status];

            $query = $this->model->create($data);
        }
        return $query;
    }

    public function checkUserFollow($user_id, $by)
    {
        $query = $this->model->where('user_id', '=', $user_id)->where('by', '=', $by);
        $result = $query->count();

        return $result;
    }

    public function unFollowUser($user_id, $by)
    {
        $query = $this->model->where('user_id', '=', $user_id)->where('by', '=', $by);
        $result = $query->update(['status' => config('common.status_follow.un_follow')]);

        return $result;
    }

    public function getUserFollowExist($userId)
    {
        $query = $this->model->where('by', '=', $userId)->where('status', '=',
            config('common.status_follow.on_follow'));
        $result = $query->get();
        return $result;
    }

    public function getFollow($user_id,$by)
    {
        $follow = $this->model->where('user_id','=',$user_id)->where('by','=',$by)->first();

        return $follow;
    }
}
