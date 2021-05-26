<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PositionDivisionResource;
use App\Http\Services\PositionDivisionService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StorePositionDivision;

class PositionDivisionController extends Controller
{
    public $positionDivisionService;
    public $userService;

    public function __construct(
        PositionDivisionService $positionDivisionService,
        UserService $userService
    )
    {
        $this->positionDivisionService = $positionDivisionService;
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePositionDivision $request)
    {
        try {
             //cần check xem cái position đã có trong division đấy chưa
             $data_check = [
                'division_id' => $request->division_id,
                'position_id' => $request->position_id,
            ];
            $check = $this->positionDivisionService->CheckPosition($data_check);
            if($check){
                $errors = [
                    'errors' => [
                        'position_id' => ['Position is exist in division']
                    ]
                ];
                return response()->json($errors,422);
                // return (new PositionResource($errors))->response()->setStatusCode(422);
            }
            $new_position_division = $this->positionDivisionService->createPositionDivision($request->all());
            return (new PositionDivisionResource($new_position_division))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('CreatePositionDivision>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
           $position_division = $this->positionDivisionService->getPositionByDivision($id);
           return (new PositionDivisionResource($position_division))->response()->setStatusCode(200);
       } catch (\Exception $e) {
           $message = $e->getMessage();

           return $message;
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $check = $this->userService->checkUserExistInPosition($id);
            if($check)
            {
                return response()->json([
                    'error' => 'You don\'t delete Position.Because It has many user has position!'], 404);
            }
            $this->positionDivisionService->deletePositionDivision($id);
            return response(null,200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('DeletePosition>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    public function postSearch($id,Request $request)
    {
        try {
            $request->validate([
                'per_page' => 'numeric|min:1|max:5'
            ]);
            $per_page = $request->input('per_page',5);
            $position_division = $this->positionDivisionService->getPositionBySearch($id,$request->all(),$per_page);
            return (new PositionDivisionResource($position_division))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
 
            return $message;
        }
    }

    public function getAllPositionNoPaginate($id)
    {
        try {
            $position_division = $this->positionDivisionService->getAllPositionNoPaginate($id);
            return (new PositionDivisionResource($position_division))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
 
            return $message;
        }
    }

    public function postSearchNoPaginate($id,Request $request)
    {
        try {
            $position_division = $this->positionDivisionService->postSearchNoPaginate($id,$request->all());
            return (new PositionDivisionResource($position_division))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
 
            return $message;
        }
    }
}
