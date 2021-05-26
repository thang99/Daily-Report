<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\PositionDivisionRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentPositionDivisionRepository extends EloquentBaseRepository implements PositionDivisionRepository
{
    public function getAllPositionDivision()
    {
        $data = DB::table('position_division')
            ->join('divisions', 'position_division.division_id', '=', 'divisions.id')
            ->join('positions', 'position_division.position_id', '=', 'positions.id')
            ->select('position_division.*', 'divisions.name as name_division', 'positions.name as name_position','positions.status')
            ->orderByDesc('position_division.created_at')
            ->paginate(5);
        return $data;
    }

    public function CheckPositionExist($data)
    {
        $check = false;
        $data = DB::table('position_division')
            ->where('position_division.division_id','=',$data['division_id'])
            ->where('position_division.position_id', $data['position_id'])->get();
        if(count($data) > 0)
        {
            $check = true;
        }
        return $check;
    }

    public function getPositionByDivision($id)
    {
        $data = DB::table('position_division')
        ->join('divisions', 'position_division.division_id', '=', 'divisions.id')
        ->join('positions', 'position_division.position_id', '=', 'positions.id')
        ->select('position_division.*','divisions.name as name_division', 'positions.name as name_position')
        ->where('position_division.division_id', '=', $id)
        ->orderByDesc('position_division.created_at')
        ->paginate(5);

        return $data;
    }

    public function getDivisionId($id)
    {
        $division = $this->model::select('division_id')->where('id','=',$id)->get();

        return $division;
    }

    public function getIdDivisionPosition($id)
    {
        $position_division = $this->model::select('id')->where('division_id','=',$id)->get();

        return $position_division;
    }

    public function getPositionDivisionId($data1,$data2)
    {
        $position_division = $this->model->where('position_id','=',$data1)->where('division_id','=',$data2)->first();
        $id = $position_division->id;

        return $id;
    }

    public function getPositionId($id) 
    {
        $position_id = $this->model::select('position_id')->where('division_id','=',$id)->get();
        
        return $position_id;
    }

    public function getPositionBySearch($id,$data)
    {
       
        $sql = DB::table('position_division')
        ->join('divisions', 'position_division.division_id', '=', 'divisions.id')
        ->join('positions', 'position_division.position_id', '=', 'positions.id')
        ->select('position_division.*','divisions.name as name_division', 'positions.name as name_position')
        ->where('position_division.division_id', '=', $id);
        if($data['keySearch'] && $data['keySearch']!='')
        {
            $sql->where('positions.name','like', '%' . $data['keySearch'] . '%');
        }
        if($data['startDate']!=''){
            $sql->where('position_division.created_at','>=',$data['startDate']." 00:00:00");
        }
        if($data['endDate']!='') {
            $sql->where('position_division.created_at','<=',$data['endDate']." 23:59:59");
        }
        if($data['startDate']!='' && $data['endDate']!='')
        {
            $sql->whereBetween('position_division.created_at',[$data['startDate']." 00:00:00",$data['endDate']." 23:59:59"]);
        }
        $result = $sql->orderByDesc('position_division.created_at')->paginate(5);
        
        return $result;
    }

    public function getAllPositionNoPaginate($id)
    {
        $data = DB::table('position_division')
        ->join('divisions', 'position_division.division_id', '=', 'divisions.id')
        ->join('positions', 'position_division.position_id', '=', 'positions.id')
        ->select('position_division.*','divisions.name as name_division', 'positions.name as name_position')
        ->where('position_division.division_id', '=', $id)
        ->orderByDesc('position_division.created_at')
        ->get();

        return $data;
    }

    public function postSearchNoPaginate($id,$data) 
    {
        $sql = DB::table('position_division')
        ->join('divisions', 'position_division.division_id', '=', 'divisions.id')
        ->join('positions', 'position_division.position_id', '=', 'positions.id')
        ->select('position_division.*','divisions.name as name_division', 'positions.name as name_position')
        ->where('position_division.division_id', '=', $id);
        if($data['keySearch'] && $data['keySearch']!='')
        {
            $sql->where('positions.name','like', '%' . $data['keySearch'] . '%');
        }
        if($data['startDate']!=''){
            $sql->where('position_division.created_at','>=',$data['startDate']." 00:00:00");
        }
        if($data['endDate']!='') {
            $sql->where('position_division.created_at','<=',$data['endDate']." 23:59:59");
        }
        if($data['startDate']!='' && $data['endDate']!='')
        {
            $sql->whereBetween('position_division.created_at',[$data['startDate']." 00:00:00",$data['endDate']." 23:59:59"]);
        }
        $result = $sql->orderByDesc('position_division.created_at')->get();
        
        return $result;
    }
}
