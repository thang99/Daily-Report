<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\PositionRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentPositionRepository extends EloquentBaseRepository implements PositionRepository
{
    public function getAllPosition()
    {
        return $this->model->where('status', '!=', -1)->orderByDesc('created_at')->paginate(5);
    }

    // get all not paginate
    public function getAll()
    {
        return $this->model->where('status', '=', 1)->orderByDesc('created_at')->get();
    }
    
    public function getPositionByDivision($id)
    {
        $positions = $this->model::whereIn('id',$id)->get();

        return $positions;
    }

    public function getNamePosition($id)
    {
        $position_name = $this->model::select('name')->where('id','=',$id)->get();

        return $position_name;
    }

    public function postSearchPosition($data)
    {
        $sql = DB::table('positions');
        if($data['keySearch'] && $data['keySearch']!='')
        {
            $sql->where('name','like', '%' . $data['keySearch'] . '%');
        }
        if($data['startDate']!=''){
            $sql->where('created_at','>=',$data['startDate']." 00:00:00");
        }
        if($data['endDate']!='') {
            $sql->where('created_at','<=',$data['endDate']." 23:59:59");
        }
        if($data['startDate']!='' && $data['endDate']!='')
        {
            $sql->whereBetween('created_at',[$data['startDate']." 00:00:00",$data['endDate']." 23:59:59"]);
        }
        $result = $sql->orderByDesc('created_at')->paginate(5);
        
        return $result;
    }

    public function getAllNoPaginate()
    {
        return $this->model->where('status', '!=', -1)->orderByDesc('created_at')->get();
    }

    public function deletePosition($id)
    {
        //remove position
        $position = $this->model->find($id);
        $position->delete();
    }

    public function checkPositionInDivision($id)
    {
        $check = false;
        $data = DB::table('positions')
            ->join('position_division', 'position_division.position_id', '=', 'positions.id')
            ->where('position_division.position_id','=',$id)
            ->get();
        if(count($data) > 0)
        {
            $check = true;
        }

        return $check;
    }
}
