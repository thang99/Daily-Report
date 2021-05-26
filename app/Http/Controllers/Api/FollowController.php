<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FollowResource;
use App\Http\Services\FollowService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    protected $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    /**
     * Get user follow by user id
     *
     * @param $userId
     * @return FollowResource
     */
    public function getUsersFollow($userId)
    {
        //get data of user follow by userId
        $result = $this->followService->getAllUsersFollow($userId);

        return $result;
    }

    /**
     * Follow User
     *
     * @param Request $request
     * @return string
     */
    public function followUser(Request $request)
    {

        try {
            //get data from request
            $user_id = $request->user_id;
            $by = $request->follow_id;
            $status = config('common.status_follow.on_follow');

            //follow user
            $followResource = $this->followService->followUser($user_id, $by, $status);

            $result = new FollowResource($followResource);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    /**
     * UnFollow User
     *
     * @param Request $request
     * @return string
     */
    public function unFollowUser(Request $request)
    {
        try {
            $user_id = $request->user_id;
            $by = $request->follow_id;

            //unfollow user
            $result = $this->followService->unFollowUser($user_id, $by);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function suggestUsersFollow($userId)
    {

        $users = $this->followService->getSuggestUser($userId);

        return $users;
    }


}
