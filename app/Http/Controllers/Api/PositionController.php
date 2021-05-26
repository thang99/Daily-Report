<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PositionResource;
use App\Http\Services\PositionService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePostionRequest;

class PositionController extends Controller
{
    public $positionService;

    public function __construct(
        PositionService $positionService
    )
    {
        $this->positionService = $positionService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page',5);
        $positions = $this->positionService->getAllPaginate($per_page);
        return new PositionResource($positions);
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
    public function store(StorePositionRequest $request)
    {
        try {
            $new_position = $this->positionService->createPosition($request->all());
            return (new PositionResource($new_position))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('CreatePosition>>>>' . json_encode($e->getMessage()));
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
        $postion = $this->positionService->findPosition($id);
        return (new PositionResource($postion))->response()->setStatusCode(200);
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
    public function update(UpdatePostionRequest $request, $id)
    {
        
        try {
            $position = $this->positionService->updatePosition($id,$request->all());
            return (new PositionResource($position))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('UpdatePosition>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         //
        try {
            $check = $this->positionService->checkPositionInDivision($id);
            if($check)
            {
                return response()->json([
                    'error' => 'You don\'t delete Position.Because It it belongs to many Division!'], 404);
            }
            $this->positionService->deletePosition($id);
            return response(null,200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('DeletePosition>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPosition()
    {
        $positions = $this->positionService->getAll();
        return new PositionResource($positions);
    }

    public function postSearchPosition(Request $request)
    {
        try {
            $request->validate([
                'per_page' => 'numeric|min:1|max:5'
            ]);
            $per_page = $request->input('per_page',5);
            $positions = $this->positionService->postSearchPosition($request->all(),$per_page);
            
            return (new PositionResource($positions))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
 
            return $message;
        }
    }
    

    public function getAllPositionNoPaginate()
    {
        $positions = $this->positionService->getAllNoPaginate();
        return new PositionResource($positions);
    }
}
