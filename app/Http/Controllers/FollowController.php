<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\FollowService;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    protected $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    public function index()
    {
        return view('user.follow.index');
    }

    public function suggestUsersFollow()
    {
        return view('user.follow.suggest');
    }
}
