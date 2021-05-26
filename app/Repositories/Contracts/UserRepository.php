<?php

namespace App\Repositories\Contracts;

/**
 * UserRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface UserRepository extends BaseRepository
{
    public function getAllManager();

    public function getEditManager($id);

    public function getFollowUser($userFollowId);
    public function getPositionDivisionId($id);
    public function getUserByManager($data,$id);
    public function getUserNoDivision();
    public function getAllUser();
    public function findUserAndRole($id);
    public function getAllRoleUser();
    public function postUserSearch($data);
    public function postUserSearchPaginate($data);
    public function checkUserExistInPosition($id);
    public function getInfoManagerDivision($id);

    /**
     * @param $data
     * @param $userId
     * @return mixed
     */
    public function sendNotificationMessage($data, $userId);

    public function getManager($id);

    /**
     * Get list Notification by user id.
     *
     * @param $userId
     * @return mixed
     */
    public function getListNotiByUser($userId);

    public  function unReadNoti($userId);
    
    public function searchUser($data1,$data2,$data3);

    public function findPositionByUser($id);

    public function getDivisionOfUser($id);
    
    public function getUserSameDivision($id,$id_pd);
}
