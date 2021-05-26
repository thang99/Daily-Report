<?php

namespace App\Http\Controllers;

use App\Http\Services\DivisionService;
use App\Http\Services\PositionDivisionService;
use App\Http\Services\PositionService;
use App\Http\Services\ReportService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    public $userService;
    public $positionDivisionService;
    public $positionService;
    public $divisionService;
    public $reportService;


    public function __construct(UserService $userService,PositionDivisionService $positionDivisionService,PositionService $positionService, DivisionService $divisionService, ReportService $reportService)
    {
        $this->userService = $userService;
        $this->positionDivisionService = $positionDivisionService;
        $this->positionService = $positionService;
        $this->divisionService = $divisionService;
        $this->reportService = $reportService;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::check()) {
            $idUserLogin = Auth::id();
        }
        
        $user = $this->userService->findUser($id);

        if($user->position_division_id !== null) {
            $division_id = $this->positionDivisionService->getDivisionId($user->position_division_id);
            $position_division = $this->positionDivisionService->getPositionId($division_id[0]->division_id);
            $position = $this->positionService->getNamePosition($position_division[0]->position_id);
            $division = $this->divisionService->getDivision($division_id[0]->division_id);
        } else {
            $position = 0;
            $division = 0;
        }
        
        // $reports = $this->reportService->getReportUserWhere($id);
        return view('profile.index',compact('user','position','division','id','idUserLogin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userService->findUser($id);
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
