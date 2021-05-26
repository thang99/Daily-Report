<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStore;
use App\Http\Services\RoleService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;


    public function __construct(RoleService $roleService)
    {

        $this->roleService = $roleService;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.role.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStore $request)
    {

        try {

            $admin = config('common.role_user.admin');

            $user = config('common.role_user.user');

            $manager = config('common.role_user.manager');

            $data = [$admin, $user, $manager];


            $result = $this->roleService->createNewRole($data);

            return redirect()->back()->with('msg', 'Insert Role Success');
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }

    }

    public function giveRoleUser()
    {
        try {
            $result = $this->roleService->giveRoleUser();
            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $message;
        }
    }
}
