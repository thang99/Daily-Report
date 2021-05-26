<?php

namespace App\Repositories\Contracts;

/**
 * FollowRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface FollowRepository extends BaseRepository
{
    /**
     * Get user follows of user.
     * @param $userId
     *
     * @return mixed
     */
    public function getUsersFollow($userId);

    /**
     * follow user.
     *
     * @param $user_id
     * @param $by
     * @return mixed
     */
    public function storeFollowUser($user_id, $by, $status);

    /**
     * Unfollow user.
     *
     * @param $user_id
     * @param $by
     * @return mixed
     */
    public function unFollowUser($user_id, $by);

    /**
     * Get suggest user.
     *
     * @return mixed
     */
    public function getUserFollowExist($userId);

    public function getFollow($user_id, $by);

}
