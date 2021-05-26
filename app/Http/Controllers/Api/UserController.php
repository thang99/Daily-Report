<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\ChangePassRequest;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use PhpParser\Node\Stmt\TryCatch;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Util\Json;

class UserController extends Controller
{
    public $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function getAllUser()
    {
        $users = $this->userService->getAllUser();

        return new UserResource($users);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $users = $this->userService->getAllPaginate($per_page);

        return new UserResource($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            if ($request->hasFile('avatar')) {
                $resultFile = Helper::uploadImage($request->avatar, 'users');
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'birthday' => $request->birthday,
                'status' => $request->status == 'false' ? 0 : 1,
                'role' => $request->role == '' ? null : explode(',', $request->role),
                'avatar' => $resultFile ? $resultFile : null
            ];
            $new_user = $this->userService->createUser($data);
            return (new UserResource($new_user))->response()->setStatusCode(200);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info('CreateUser>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
        try {
            $user = $this->userService->findUserAndRole($id);
            return (new UserResource($user))->response()->setStatusCode(200);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info('GetUser>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    //UpdateUser
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->findUserAndRole($id);
            $resultFile = '';
            if ($request->hasFile('avatar')) {
                $resultFile = Helper::uploadImage($request->avatar, 'users');
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'birthday' => $request->birthday,
                'status' => $request->status == 'false' ? 0 : 1,
                'role' => $request->role == '' ? '' : explode(',', $request->role),
                'avatar' => $resultFile ? $resultFile : $user->avatar
            ];
            $user_update = $this->userService->updateUser($id, $data);
            return (new UserResource($user_update))->response()->setStatusCode(200);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info('UpdateUser>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);
            return response(null, 200);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info('DeleteUser>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    //get all manager
    public function getAllManager()
    {
        try {
            $managers = $this->userService->getAllManager();
            return (new UserResource($managers))->response()->setStatusCode(200);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info('getAllManager>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    //get edit manager
    public function getEditManager($id)
    {
        try {
            $managers = $this->userService->getEditManager($id);
            return (new UserResource($managers))->response()->setStatusCode(200);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info('getEditManager>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    // post change pass
    // ChangePass
    public function changePass($id, Request $request)
    {
        try {
            $user = $this->userService->findUserAndRole($id);
            $checkPass = Hash::check($request->currentPass, $user->password);
            if ($checkPass) {
                $data = [
                    'password' => Hash::make($request->newPass)
                ];
                $managers = $this->userService->changePass($id, $data);
                return (new UserResource($managers))->response()->setStatusCode(200);

            }
            $errorPassCurrent = [
                'currentPass' => ['Password current not correct !']
            ];
            return response()->json([
                'errors' => $errorPassCurrent
            ], 422);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info('changePass>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    // get All role user
    public function getAllRoleUser()
    {
        try {
            $users = $this->userService->getAllRoleUser();
            return (new UserResource($users))->response()->setStatusCode(200);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info('getAllManager>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    //search User
    public function postUserSearch(Request $request)
    {
        try {
            $users = $this->userService->postUserSearch($request->all());
            return (new UserResource($users))->response()->setStatusCode(200);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info('postUserSearch>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    public function postUserSearchPaginate(Request $request)
    {
        try {
            $request->validate([
                'per_page' => 'numeric|min:1|max:5'
            ]);
            $per_page = $request->input('per_page',5);
            $users = $this->userService->postUserSearchPaginate($request->all(),$per_page);

            return (new UserResource($users))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('postUserSearchPaginate>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    public function getInfoManagerDivision($id)
    {
        try {
            $user = $this->userService->getInfoManagerDivision($id);
            return (new UserResource($user))->response()->setStatusCode(200);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info('getInfoManagerDivision>>>>' . json_encode($e->getMessage()));
        }
    }
}

