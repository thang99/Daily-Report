<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Http\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getListNotification(Request $request)
    {
        $userId = $request->id;
        $listNoti = $this->notificationService->getListNoti($userId);
        $result = new NotificationResource($listNoti);

        return $result;
    }

    public function countUnreadNotify(Request $request)
    {
        $userId = $request->id;
        $countNoti = $this->notificationService->countUnreadNotify($userId);
        $dataResult = ['count' => $countNoti];
        $result = new NotificationResource($dataResult);

        return $result;
    }

    public function markAsReadNotify(Request $request)
    {

        $idNotify = $request->noti_id;
        $id = $request->id;
        $resultMark = $this->notificationService->markAsReadNoti($idNotify, $id);
        $result = new NotificationResource($resultMark);

        return $result;
    }


}
