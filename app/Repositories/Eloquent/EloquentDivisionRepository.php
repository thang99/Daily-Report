<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\DivisionRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\Models\User;
use App\Models\ManagerDivision;

/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentDivisionRepository extends EloquentBaseRepository implements DivisionRepository
{
    public function getAllDivision()
    {
        $data = DB::table('divisions')
            ->leftJoin('manager_division', 'divisions.id', '=', 'manager_division.division_id')
            ->leftJoin('users','users.id', '=', 'manager_division.user_id')
            ->select('divisions.*','users.name as user_name', 'users.id as user_id')
            ->orderByDesc('divisions.created_at')
            ->paginate(5);

        return $data;
    }

    // get all not paginate
    public function getAll()
    {
        return $this->model->where('status', '=', 1)->orderByDesc('created_at')->get();
    }

    // check division has position
    public function checkPosition($id)
    {
        $check = false;
        $data = DB::table('divisions')
            ->join('position_division', 'position_division.division_id', '=', 'divisions.id')
            ->where('position_division.division_id','=',$id)
            ->get();
        if(count($data) > 0)
        {
            $check = true;
        }

        return $check;
    }

    // create division and add manager
    public function createDivision($data)
    {
        $request = [
            'name' => $data['name'],
            'status' => $data['status']
        ];
        $division = Division::create($request);
        $division->save();
        
        //create role manager in user
        if(isset($data['user_id']))
        {
            $user = User::find($data['user_id']);
            $user->assignRole(config('common.role_user.manager'));
            //update position_division_id in user when user->manager
            $dataUpdate['position_division_id'] = null;
            $user->update($dataUpdate);

            //add table manager_division
            $request_manager = [
                'user_id' => $data['user_id'],
                'division_id' => $division->id
            ];
            ManagerDivision::create($request_manager);
        }
    }

    //update division and manager
    public function updateDivision($id,$data)
    {
        //update division
        $request = [
            'name' => $data['name'],
            'status' => $data['status']
        ];
        $division = Division::find($id);
        $division->update($request);
        
        //save manager in table manager_division
        $manager_division = ManagerDivision::where('division_id','=',$id)->first();
        if(isset($data['user_id']) && $data['user_id'] != null)
        {
            // check division has manager by table manager_division, if exist update manager
            if(isset($manager_division) && $manager_division != null)
            {
                //remove role old_manager
                $user = User::find($manager_division -> user_id);
                $user->removeRole(config('common.role_user.manager'));

                //update new_manager
                $update_manager_division = [
                    'user_id' => $data['user_id'],
                    'division_id' => intval($id)
                ];
                ManagerDivision::where('id',$manager_division->id)->update($update_manager_division);
                
                //add role manager new_user
                $user_new = User::find($data['user_id']);
                $user_new->assignRole(config('common.role_user.manager'));
                $dataUpdate['position_division_id'] = null;
                $user->update($dataUpdate);
            } else {
                
                //if not exist, create new manager 
                $request_manager = [
                    'user_id' => $data['user_id'],
                    'division_id' => intval($id)
                ];
                ManagerDivision::create($request_manager);
                //set role manager
                $user = User::find($data['user_id']);
                $user->assignRole(config('common.role_user.manager'));
            }
        }
        else
        {
            // if user_id not select remove role manager and remove in table manager_division
            if(isset($manager_division) && $manager_division != null)
            {
                //remove role old_manager
                $user = User::find($manager_division -> user_id);
                $user->removeRole(config('common.role_user.manager'));

                //remove
                ManagerDivision::where('id',$manager_division->id)->delete();

            }
        }

    }

    //delete division and remove role manager
    public function deleteDivision($id)
    {
        //remove division
        $division = Division::find($id);
        $division->delete();
        //remove manage division and remove role manager
        $manager_division = ManagerDivision::where('division_id','=',$id)->first();
        if($manager_division)
        {
            $user = User::find($manager_division -> user_id);
            $user->removeRole(config('common.role_user.manager'));

            $delete_manager_division = ManagerDivision::find($manager_division->id);
            $delete_manager_division->delete();
        }

    }

    public function getDivision($id)
    {
        $division = $this->model::where('id','=',$id)->get();

        return $division;
    }

    public function postSearchDivision($data)
    {
        $sql = DB::table('divisions')
            ->leftJoin('manager_division', 'divisions.id', '=', 'manager_division.division_id')
            ->leftJoin('users','users.id', '=', 'manager_division.user_id')
            ->select('divisions.*','users.name as user_name', 'users.id as user_id');
        if($data['keySearch'] && $data['keySearch']!='')
        {
            $sql->where('divisions.name','like', '%' . $data['keySearch'] . '%');
        }
        if($data['startDate']!=''){
            $sql->where('divisions.created_at','>=',$data['startDate']." 00:00:00");
        }
        if($data['endDate']!='') {
            $sql->where('divisions.created_at','<=',$data['endDate']." 23:59:59");
        }
        if($data['startDate']!='' && $data['endDate']!='')
        {
            $sql->whereBetween('divisions.created_at',[$data['startDate']." 00:00:00", $data['endDate']." 23:59:59"]);
        }
        $result = $sql->orderByDesc('divisions.created_at')->paginate(5);
        
        return $result;
    }

    public function getAllDivisionNoCondition() 
    {
        $data = DB::table('divisions')
        ->leftJoin('manager_division', 'divisions.id', '=', 'manager_division.division_id')
        ->leftJoin('users','users.id', '=', 'manager_division.user_id')
        ->select('divisions.*','users.name as user_name', 'users.id as user_id')
        ->orderByDesc('divisions.created_at')
        ->get();

        return $data;
    }

    public function postSearchDivisionNoPaginate($data)
    {
        $sql = DB::table('divisions')
            ->leftJoin('manager_division', 'divisions.id', '=', 'manager_division.division_id')
            ->leftJoin('users','users.id', '=', 'manager_division.user_id')
            ->select('divisions.*','users.name as user_name', 'users.id as user_id');
        if($data['keySearch'] && $data['keySearch']!='')
        {
            $sql->where('divisions.name','like', '%' . $data['keySearch'] . '%');
        }
        if($data['startDate']!=''){
            $sql->where('divisions.created_at','>=',$data['startDate']." 00:00:00");
        }
        if($data['endDate']!='') {
            $sql->where('divisions.created_at','<=',$data['endDate']." 23:59:59");
        }
        if($data['startDate']!='' && $data['endDate']!='')
        {
            $sql->whereBetween('divisions.created_at',[$data['startDate']." 00:00:00",$data['endDate']." 23:59:59"]);
        }
        $result = $sql->orderByDesc('divisions.created_at')->get();
        
        return $result;
    }
}
