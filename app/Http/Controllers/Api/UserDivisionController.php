<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use  App\Http\Resources\UserDivisionResource;
use App\Http\Services\UserDivisionService;

class UserDivisionController extends Controller
{
    public $userDivisionService;

    public function __construct(
        userDivisionService $userDivisionService
    )
    {
        $this->userDivisionService = $userDivisionService;
    }

    public function getUserByDivision($search, Request $request)
    {
        try {
            $request->validate([
                'per_page' => 'numeric|min:1|max:5'
            ]);
            $per_page = $request->input('per_page',5);
            $new_user = $this->userDivisionService->getUserByDivision($search,$per_page);
            return (new UserDivisionResource($new_user))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('CreateUser>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }
}
