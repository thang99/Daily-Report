<?php

namespace App\Http\Services;

use App\Models\User;
use App\Notifications\MessageNotification;
use App\Repositories\Contracts\NotificationRepository;
use App\Repositories\Contracts\UserRepository;
use Exception;


class NotificationService
{

    public $notificationRepository;
    public $userRepository;

    public function __construct(NotificationRepository $notificationRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function sendNotiMsg($data, $userId)
    {
        try {
            $result = $this->userRepository->sendNotificationMessage($data, $userId);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getListNoti($userId)
    {
        try {

            $result = $this->userRepository->getListNotiByUser($userId);

            return $result;

        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function countUnreadNotify($userId)
    {
        try {

            $result = $this->userRepository->unReadNoti($userId);

            return $result;

        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function markAsReadNoti($idNotify, $id)
    {
        try {
            $userNotify = $this->notificationRepository->find($idNotify);

            $url = isset(json_decode($userNotify->data)->url) ? json_decode($userNotify->data)->url : '';
            $user = $this->userRepository->find($userNotify->notifiable_id);

            if ($userNotify->read_at === null) {
                $user->unreadNotifications->where('id', $idNotify)->markAsRead();

            }
//            $url = route('profile.show', ['profile' => $id]);
//
            $dataResult = ['url' => $url];

            return $dataResult;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }
}
