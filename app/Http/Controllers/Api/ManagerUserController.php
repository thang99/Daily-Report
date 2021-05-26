<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\DivisionService;
use App\Http\Services\ManagerDivisionService;
use App\Http\Services\ModelHasRolesService;
use App\Http\Services\PositionDivisionService;
use App\Http\Services\PositionService;
use App\Http\Services\RoleService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class ManagerUserController extends Controller
{
    public $userService;
    public $positionDivisionService;
    public $positionService;
    public $divisionService;
    public $managerDivisionService;

    public function __construct(
        UserService $userService,
        PositionDivisionService $positionDivisionService,
        PositionService $positionService,
        DivisionService $divisionService,
        ManagerDivisionService $managerDivisionService
    ) {
        $this->userService = $userService;
        $this->positionDivisionService = $positionDivisionService;
        $this->positionService = $positionService;
        $this->divisionService = $divisionService;
        $this->managerDivisionService = $managerDivisionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);   
        $per_page = $request->input('per_page',5);

        $idManager = $request->id;
        $division = $this->managerDivisionService->getDivision($idManager);
        $position_division_id = $this->positionDivisionService->getIdDivisionPosition($division[0]->division_id);
        $users = $this->userService->getUserByManager($position_division_id,$idManager,$per_page);
        
        return new UserResource($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ManagerUserRequest $request, $id)
    {
        $position_division_id = $this->positionDivisionService->getPositionDivisionId($request->position_id,$request->division_id);
        $data = array('position_division_id' => $position_division_id);
        $user = $this->userService->update($id, $data);

        return (new UserResource($user));
    }

    public function updatePosition(Request $request, $id)
    {
        $position_division_id = $this->positionDivisionService->getPositionDivisionId($request->position_id,$request->division_id);
        $data = array('position_division_id' => $position_division_id);
        $user = $this->userService->update($id, $data);

        return (new UserResource($user));
    }

    public function removeUserInDivision(Request $request,$id)
    {
        $data = array('position_division_id' => NULL);
        $user = $this->userService->update($id, $data);

        return (new UserResource($user));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function loadDivision(Request $request)
    {
        $idManager = $request->id;
        $division_manager = $this->managerDivisionService->getDivision($idManager);
        $division = $this->divisionService->getDivision($division_manager[0]->division_id);

        return new UserResource($division);
    }

    public function loadPosition(Request $request)
    {
        $idManager = $request->id;
        $division = $this->managerDivisionService->getDivision($idManager);
        $position_id = $this->positionDivisionService->getPositionId($division[0]->division_id);
        $positions = $this->positionService->getPositionByDivision($position_id);

        return new UserResource($positions);
    }

    public function loadUser()
    {
        $user = $this->userService->getUserNoDivision();
        
        return new UserResource($user);
    }

    public function search(Request $request)
    {
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page',5);
        
        $data = $request->get('keyword');
        $id = $request->id;
        $division = $this->managerDivisionService->getDivision($id);
        $position_division_id = $this->positionDivisionService->getIdDivisionPosition($division[0]->division_id);
        $users = $this->userService->searchUser($position_division_id,$id,$data,$per_page);

        return new UserResource($users);
    }   
}
