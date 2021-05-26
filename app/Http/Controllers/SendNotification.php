<?php

namespace App\Http\Controllers;

use App\Http\Services\NotificationService;
use App\Models\User;
use App\Notifications\MessageNotification;
use App\Notifications\TestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class SendNotification extends Controller
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function create()
    {

        return view('notification');
    }

    public function store(Request $request)
    {
//        $userId = $request->userId;
        $userId = 1;
        $data = [

            'title' => $request->title,
            'avatar' => Auth::user()->avatar,
            'message' => $request->content,
        ];
        $result = $this->notificationService->sendNotiMsg($data, $userId);

        return view('notification');
    }

}
