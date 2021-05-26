<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ReportResource;
use App\Http\Resources\UserResource;
use App\Http\Services\FollowService;
use App\Http\Services\ReportService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class ProfileController extends Controller
{
    protected $userService;
    protected $reportService;
    protected $followService;

    public function __construct(UserService $userService, ReportService $reportService, FollowService $followService)
    {
        $this->userService = $userService;
        $this->reportService = $reportService;
        $this->followService = $followService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->id;
        $iduserlogin = $request->iduserlogin;
        $reports = null;
        $division_user_login = $this->userService->getDivisionOfUser($iduserlogin);
        $division_user_follow = $this->userService->getDivisionOfUser($id);
        if ($division_user_follow[0]->division_id === $division_user_login[0]->division_id) {
            $reports = $this->reportService->getReportUserWhere($id);
        } else {
            $reports = null;
        }
        // $reports = $this->reportService->getReportUserWhere($id);
        
        return new ReportResource($reports);
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
        $user = $this->userService->findUser($id);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(ProfileRequest $request, $id)
    {
        $user = $this->userService->findUser($request->id);

        if($request->file('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('images/users',$filename);
        } else {
            $filename = $user->avatar;
        }
        $dataProfile = [
            'name' => $request->name,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'avatar' => $filename
        ];
        
        $user = $this->userService->update($id, $dataProfile);

        return new UserResource($user);
    }

    public function updatePassword(Request $request, $id)
    {
        $user = $this->userService->findUser($request->id);

        $validatedPassword = $request->validate([
            'password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password|min:8'
        ]);

        $dataPassword = [
            'password' => Hash::make($request->new_password)
        ];
    
        $user = $this->userService->update($id,$dataPassword);
    
        return new UserResource($user);
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

    public function loadFollow(Request $request)
    {
        $id = $request->id;
        $idUserLogin = $request->iduserlogin;
        $follow = $this->followService->getFollow($id,$idUserLogin);
        if(is_null($follow)) {
            $status = 0;
        } else {
            $status = $follow->status;
        }
        return response()->json($status);
    }

    public function followUser(Request $request)
    {
        // $user_id = $request->id;
        // $by = $request->iduserlogin;
        // $status =config('common.status_follow.on_follow');
        // $follow = $this->followService->follow($user_id,$by,$status);
        // $status = $follow->status;

        // return response()->json($status);
    }

    public function unfollowUser(Request $request)
    {
        // $user_id = $request->id;
        // $by = $request->iduserlogin;      
        // $follow = $this->followService->unfollowUser($user_id,$by);

        // return response()->json($follow);
    }
}
