<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ReportRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;
/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentReportRepository extends EloquentBaseRepository implements ReportRepository
{
    public function getReportByManager($id)
    {
        $reports = $this->model->with('user')->where('assign_to','=',$id)->orderByDesc('created_at')->paginate(5);

        return $reports;
    }

    public function filterByDay($data, $id)
    {
        // $reports = $this->model->with('user')->where('assign_to','=',$id)->where('created_at','>=',$data)->paginate(5);
        $reports = $this->model->with('user')->where('assign_to','=',$id)->where('created_at','>=',$data)->paginate(5);

        return $reports;
    }

    public function filterByMonth($data, $id)
    {
        // $reports = $this->model->with('user')->where('assign_to','=',$id)->where('created_at','<=',$data)->paginate(5);
        $reports = $this->model->with('user')->where('assign_to','=',$id)->where('created_at','<=',$data." 23:59:59")->paginate(5);

        return $reports;
    }

    public function filterAll($data1,$data2,$id)
    {
        // $reports = $this->model->with('user')->where('assign_to','=',$id)->where('created_at','>=',$data1)->where('created_at','<=',$data2)->paginate(5);
        $reports = $this->model->with('user')->where('assign_to','=',$id)->whereRaw("(created_at >= ? AND created_at <= ?)", [$data1." 00:00:00", $data2." 23:59:59"])->paginate(5);

        return $reports;
    }

    public function getReportUserWhere($userId)
    {
        $query = $this->model->with(['user', 'assignUser'])
            ->where('user_id', '=', $userId);
        $result = $query->paginate(5);

        return $result;
    }

    public function findReportWhere($id)
    {
        $query = $this->model->with(['user', 'assignUser','feedback'])
            ->where('id', '=', $id);
        $result = $query->first();

        return $result;
    }

    public function getReportByUser($id)
    {
        $reports = $this->model->with('assignUser')->where('user_id','=',$id)->orderByDesc('created_at')->paginate(5);
      
        return $reports;
    }

    public function getStatusReport($id) 
    {
        $status = $this->model::select('status')->where('id','=',$id)->get();

        return $status;
    }

    //get report limit
    public function getReportLimit()
    {
        $reports = $this->model->with(['user','assignUser'])->orderBy('created_at','desc')->paginate(5);
        return $reports;
    }

    //post report search
    public function postReportSearch($data)
    {
        $sql = $this->model->with(['user','assignUser']);
        if($data['searchKey'] && $data['searchKey'] != null)
        {
            $sql->where('title', 'like', '%' . $data['searchKey'] . '%');
        }

        if($data['endDate']!='')
        {
            $sql->where('created_at','<=',$data['endDate']." 23:59:59");
        }

        if($data['startDate'] && $data['endDate'])
        {
            $sql->whereBetween('created_at',[$data['startDate']." 00:00:00",$data['endDate']." 23:59:59"]);
        }
        
        if($data['status'] != 2)
        {
            $sql->where('status','=',$data['status']);
        }
        $reports = $sql->orderBy('created_at','desc')->paginate(5);

        return $reports;
    }

    public function searchReportByTitle($data,$id)
    {
        $reports = $this->model->with('assignUser')->where('title','like','%'.$data.'%')->where('user_id','=',$id)->paginate(5);

        return $reports;
    }

    public function searchReportByDate($from,$to,$id)
    {
        // $reports = $this->model->with('assignUser')->where('created_at','>=',$from)->where('created_at','<=',$to)->where('user_id','=',$id)->paginate(5);   
        $reports = $this->model->with('assignUser')->whereRaw("(created_at >= ? AND created_at <= ?)", [$from." 00:00:00", $to." 23:59:59"])->paginate(5);

        return $reports;
    }

    public function searchReportByTitleAndDate($data,$from,$to,$id)
    {
    //  $reports = $this->model->with('assignUser')->where('title','like','%'.$data.'%')->where('created_at','>=',$from)->where('created_at','<=',$to)->where('user_id','=',$id)->paginate(5);
        $reports = $this->model->with('assignUser')->where('title','like','%'.$data.'%')->whereRaw("(created_at >= ? AND created_at <= ?)", [$from." 00:00:00", $to." 23:59:59"])->where('user_id','=',$id)->paginate(5);

        return $reports; 
    }

    public function getReportUserSameDivision($id)
    {
        // $reports = $this->model->with(['user', 'assignUser'])->whereIn('user_id', $id)->orderBy('created_at', 'desc')->paginate(5);
        $reports = DB::table('reports')->join('users as user_sender','reports.user_id','=','user_sender.id')
                ->join('users as user_receiver','reports.assign_to','=','user_receiver.id')
                ->join('position_division','user_sender.position_division_id','=','position_division.id')
                ->join('positions','position_division.position_id','=','positions.id')
                ->whereIn('reports.user_id', $id)->orderBy('created_at', 'desc')
                ->select('reports.*','user_sender.name as sender_name','user_receiver.name as receiver_name','positions.name as position_name')
                ->paginate(5);
        
        return $reports;
    }

    public function searchReportBySender($data)
    {
        $reports = DB::table('reports')->join('users as user_sender','reports.user_id','=','user_sender.id')
                ->join('users as user_receiver','reports.assign_to','=','user_receiver.id')
                ->join('position_division','user_sender.position_division_id','=','position_division.id')
                ->join('positions','position_division.position_id','=','positions.id')
                ->where('user_sender.name','LIKE','%'.$data.'%')
                ->select('reports.*','user_sender.name as sender_name','user_receiver.name as receiver_name','positions.name as position_name')
                ->paginate(5);

        return $reports;
    }

    public function searchReportByDateSender($from,$to)
    {
        $reports = DB::table('reports')->join('users as user_sender','reports.user_id','=','user_sender.id')
                ->join('users as user_receiver','reports.assign_to','=','user_receiver.id')
                ->join('position_division','user_sender.position_division_id','=','position_division.id')
                ->join('positions','position_division.position_id','=','positions.id')
                ->whereRaw("(reports.created_at >= ? AND reports.created_at <= ?)", [$from." 00:00:00", $to." 23:59:59"])
                ->select('reports.*','user_sender.name as sender_name','user_receiver.name as receiver_name','positions.name as position_name')
                ->paginate(5);

        return $reports;
    }

    public function searchReportByDateAndNameSender($data,$from,$to)
    {
        $reports = DB::table('reports')->join('users as user_sender','reports.user_id','=','user_sender.id')
                ->join('users as user_receiver','reports.assign_to','=','user_receiver.id')
                ->join('position_division','user_sender.position_division_id','=','position_division.id')
                ->join('positions','position_division.position_id','=','positions.id')
                ->where('user_sender.name','LIKE','%'.$data.'%')->whereRaw("(reports.created_at >= ? AND reports.created_at <= ?)", [$from." 00:00:00", $to." 23:59:59"])
                ->select('reports.*','user_sender.name as sender_name','user_receiver.name as receiver_name','positions.name as position_name')
                ->paginate(5);

        return $reports; 
    }

}
