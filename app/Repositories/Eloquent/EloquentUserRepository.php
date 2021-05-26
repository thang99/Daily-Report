<?php

namespace App\Repositories\Eloquent;

use App\Notifications\MessageNotification;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Symfony\Component\Console\Helper\Helper;

/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
    public function getAllManager()
    {
        $data = DB::select(DB::raw("SELECT model_id FROM model_has_roles
            WHERE model_has_roles.role_id = 2
            EXCEPT
            SELECT model_id FROM model_has_roles
            WHERE model_has_roles.role_id = 3"));
        $arr = [];
        foreach ($data as $key => $item) {
            $arr[$key] = $item->model_id;
        }
        $user = DB::table('users')
            ->whereIn('id', $arr)
            ->get();

        return $user;

    }

    //take all user role=user and manager division
    public function getEditManager($id)
    {
        $data = DB::select(DB::raw("SELECT model_id FROM model_has_roles
        WHERE model_has_roles.role_id = 2
        EXCEPT
        SELECT model_id FROM model_has_roles
        WHERE model_has_roles.role_id = 3"));
        $arr = [];
        foreach ($data as $key => $item) {
            $arr[$key] = $item->model_id;
        }
        //check exist user_id if exist take name manager
        if ($id != "null") {
            array_push($arr, intval($id));
        }
        $user = DB::table('users')
            ->whereIn('id', $arr)
            ->get();

        return $user;
    }

    public function getFollowUser($userFollowId)
    {
        $query = DB::table('users')
            ->where('users.status', '=', config('common.status_user.active'))
            ->whereNotIn('users.id', $userFollowId)
            ->where('position_division_id', '!=', null)
            ->join('position_division', 'position_division.id', '=', 'users.position_division_id')
            ->join('positions', 'positions.id', '=', 'position_division.position_id')
            ->join('divisions', 'divisions.id', '=', 'position_division.division_id')
            ->select('users.id', 'users.name', 'users.avatar',
                'positions.name as position_name', 'divisions.name as division_name');

        $result = $query->paginate(4);

        return $result;
    }

    public function getPositionDivisionId($id)
    {
        $pd_id = $this->model::where('id', '=', $id)->get();

        return $pd_id;
    }

    public function getUserByManager($data, $id)
    {
        // $users = $this->model::whereIn('position_division_id', $data)->where('id', '!=', $id)->paginate(5);
        $users = DB::table('users')->join('position_division','users.position_division_id','=','position_division.id')
                ->join('positions','positions.id','=','position_division.position_id')
                ->whereIn('users.position_division_id',$data)->where('users.id','!=',$id)
                ->select('users.*','positions.name as position_name')
                ->paginate(5);

        return $users;
    }

    public function getModelsId()
    {
        $models_id = DB::table('roles')
            ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', '=', config('common.role_user.user'))
            ->where('roles.name', '<>', config('common.role_user.manager'))
            ->where('roles.name', '<>', config('common.role_user.admin'))
            ->select('model_has_roles.model_id')
            ->get();

        return $models_id;
    }

    public function getManagers($id)
    {
        $managers = DB::table('manager_division')
            ->whereIn('user_id', $id)
            ->get()->toArray();

        return $managers;
    }

    public function getUserNoDivision()
    {
        $models_id = $this->getModelsId();
        $arr = [];
        foreach ($models_id as $key => $item) {
            $arr[$key] = $item->model_id;
        }

        $managers = $this->getManagers($arr);
        $arr2 = [];
        foreach ($managers as $key => $manager) {
            $arr2[$key] = $manager->user_id;
        }

        $users = DB::table('users')
            ->whereIn('id', $arr)
            ->whereNotIn('id', $arr2)
            ->where('position_division_id', '=', null)
            ->select('users.*')
            ->get();

        return $users;
    }

    public function getManager($id)
    {
        $user = $this->model::where('id', '=', $id)->get();

        return $user;
    }

    public function sendNotificationMessage($data, $userId)
    {
        $query = $this->model->where('id', '=', $userId)->first();
        $result = $query->notify(new MessageNotification($data));

        return $result;
    }

    public function getListNotiByUser($userId)
    {
        $user = $this->model->where('id', $userId)->first();

        $query = $user->notifications()->limit(5)->orderBy('created_at', 'asc');
        $result = $query->get();

        return $result;
    }

    public function unReadNoti($userId)
    {
        $user = $this->model->where('id', $userId)->first();

        $query = $user->unreadNotifications();

        $result = $query->count();


        return $result;
    }

    public function getAllUser()
    {
        // $users = $this->model->with('roles')->orderByDesc('created_at')->paginate(5);
        $users = DB::table('users')->leftJoin('position_division','users.position_division_id','=','position_division.id')
            ->leftJoin('positions','positions.id','=','position_division.position_id')
            ->leftJoin('divisions','divisions.id','=','position_division.division_id')
            ->select('users.*','positions.name as name_pos','divisions.name as name_div')
            ->orderByDesc('users.created_at')->paginate(5);

        return $users;
    }

    //find user by id
    public function findUserAndRole($id)
    {
        // $user = $this->model::where('id', '=', $id)->with('roles')->get();
        $user = $this->model->with('roles')->find($id);

        return $user;
    }


    public function searchUser($data1, $data2, $data3)
    {
        // $users = $this->model::whereIn('position_division_id', $data1)->where('id', '!=', $data2)->where('name', 'like',
        //     '%' . $data3 . '%')->paginate(5);
        $users = DB::table('users')->join('position_division','users.position_division_id','=','position_division.id')
        ->join('positions','positions.id','=','position_division.position_id')
        ->whereIn('users.position_division_id', $data1)->where('users.id', '!=', $data2)->where('users.name', 'like', '%' . $data3 . '%')
        ->select('users.*','positions.name as position_name','positions.id as position_id')
        ->paginate(5);

        return $users;
    }

    //get all role user
    public function getAllRoleUser()
    {
        $users = User::role('user')->paginate(5);

        return $users;
    }

    //post search user
    public function postUserSearch($data)
    {
        $sql = User::role('user');
        if ($data['searchUser'] && $data['searchUser'] != null) {
            $sql->where('name', 'like', '%' . $data['searchUser'] . '%');
        }
        $users = $sql->paginate(5);
        // dd($users);
        return $users;
    }

    //check exist user in position
    public function checkUserExistInPosition($id)
    {
        $check = false;
        $user = $this->model->where('position_division_id', '=', $id)->get();
        if(count($user) > 0)
        {
            $check = true;
        }

        return $check;
    }

    public function postUserSearchPaginate($data)
    {
        // $sql = $this->model->with('roles');
        $sql = DB::table('users')->leftJoin('position_division','users.position_division_id','=','position_division.id')
            ->leftJoin('positions','positions.id','=','position_division.position_id')
            ->leftJoin('divisions','divisions.id','=','position_division.division_id')
            ->select('users.*','positions.name as name_pos','divisions.name as name_div');
        if($data['keySearch'] && $data['keySearch']!='')
        {
            $sql->where('users.name','like', '%' . $data['keySearch'] . '%');
        }
        if($data['startDate']!=''){
            $sql->where('users.created_at','>=',$data['startDate']." 00:00:00");
        }
        if($data['endDate']!='') {
            $sql->where('users.created_at','<=',$data['endDate']." 23:59:59");
        }
        if($data['startDate']!='' && $data['endDate']!='')
        {
            $sql->whereBetween('users.created_at',[$data['startDate']." 00:00:00",$data['endDate']." 23:59:59"]);
        }
        $result = $sql->orderByDesc('users.created_at')->paginate(5);
        
        return $result;
    }
    
    public function findPositionByUser($id)
    {
        $user = DB::table('users')->join('position_division','users.position_division_id','=','position_division.id')
        ->join('positions','positions.id','=','position_division.position_id')
        ->where('users.id','=',$id)
        ->select('users.*','positions.name as position_name','positions.id as position_id')
        ->get();

        return $user;
    }

    public function getInfoManagerDivision($id)
    {
        $user = DB::table('users')
        ->join('manager_division','users.id','=','manager_division.user_id')
        ->join('divisions','manager_division.division_id','=','divisions.id')
        ->where('users.id','=',$id)
        ->select('users.*','divisions.name as name_div')
        ->get();
        return $user;
    }
    
    public function getDivisionOfUser($id)
    {
        $division = DB::table('users')->join('position_division','users.position_division_id','=','position_division.id')
            ->join('divisions','divisions.id','=','position_division.division_id')
            ->where('users.id','=',$id)
            ->select('users.*','divisions.id as division_id')->get();

            return $division;
    }
    public function getUserSameDivision($id,$id_pd)
    {
        $users = DB::table('users')->join('position_division','users.position_division_id','=','position_division.id')
            ->join('divisions','divisions.id','=','position_division.division_id')
            ->whereIn('users.position_division_id',$id_pd)
            ->where('users.id','!=',$id)
            ->select('users.id')->get();

        $arr = [];
        foreach ($users as $key => $user) {
            $arr[$key] = $user->id;
        }
        
        return $arr;
    }
}
