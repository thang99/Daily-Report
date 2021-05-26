<?php

namespace App\Http\Services;

use App\Http\Resources\FollowResource;
use App\Repositories\Contracts\FollowRepository;
use App\Repositories\Contracts\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowService
{
    public $followRepository;
    public $userRepository;

    public function __construct(FollowRepository $followRepository, UserRepository $userRepository)
    {
        $this->followRepository = $followRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Get all user follow.
     *
     * @param $userId
     * @return FollowResource
     */
    public function getAllUsersFollow($userId)
    {
        $usersFollow = $this->followRepository->getUsersFollow($userId);
        $followResource = new FollowResource($usersFollow);
        return $followResource;
    }

    /**
     * Follow User
     *
     * @param $data
     * @return FollowResource|string
     */
    public function followUser($user_id, $by, $status)
    {
        try {

            $storeFollow = $this->followRepository->storeFollowUser($user_id, $by, $status);


            if ($storeFollow) {
                $user = $this->userRepository->find($by);
                $url = '/profiles/' . $user->id;
                $data = [
//                    'avatar' => $user->avatar,
                    'title' => $user->name,
                    'message' => $user->name . ' has follow you',
                    'id' => $by,
                    'url' => $url
                ];

                $this->userRepository->sendNotificationMessage($data, $user_id);
                $dataResult = ['message' => 'Followed'];

                return $dataResult;
            }
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }

    }

    /**
     * Unfollow user.
     *
     * @param $followId
     * @return FollowResource|string
     */
    public function unFollowUser($user_id, $by)
    {
        try {
            if (!empty($user_id) && !empty($by)) {
                $result = $this->followRepository->unFollowUser($user_id, $by);

                if ($result) {
                    $data = ['message' => 'Unfollow', 'status' => 200];

                    return new FollowResource($data);
                }
            }
        } catch (Exception $e) {

            $message = $e->getMessage();

            return $message;
        }
    }

    public function getSuggestUser($userId)
    {
        try {
            //create new user Follow id
            $userFollowId = [];
            $userFollow = self::getUserFollowExist($userId);

            //for to get user follow id of user and push in array
            foreach ($userFollow as $user) {
                array_push($userFollowId, $user->user_id);
            }
            array_push($userFollowId, intval($userId));

            //get user not follow by user
            $result = $this->userRepository->getFollowUser($userFollowId);

            return new FollowResource($result);
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getUserFollowExist($userId)
    {
        $result = $this->followRepository->getUserFollowExist($userId);

        return $result;
    }

    public function getFollow($user_id, $by)
    {
        try {
            $result = $this->followRepository->getFollow($user_id,$by);

            return $result;
        } catch( \Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function follow($user_id,$by,$status)
    {
        try {
            $storeFollow = $this->followRepository->storeFollowUser($user_id, $by, $status);

            return $storeFollow;
        } catch(\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }
}
