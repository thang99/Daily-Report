<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DivisionResource;
use App\Http\Services\DivisionService;
use App\Http\Controllers\Api\Response;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Division;

class DivisionController extends Controller
{
    public $divisionService;

    public function __construct(
        DivisionService $divisionService
    )
    {
        $this->divisionService = $divisionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page',5);
        $divisions = $this->divisionService->getAllPaginate($per_page);
        return new DivisionResource($divisions);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    // StoreDivision
    public function store(StoreDivisionRequest $request)
    {
        try {
            $new_division = $this->divisionService->createDivision($request->all());

            return (new DivisionResource($new_division))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('CreateDivision>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $division = $this->divisionService->findDivision($id);
        return (new DivisionResource($division))->response()->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDivisionRequest $request, $id)
    {
        //
        try {
            $division = $this->divisionService->updateDivision($id,$request->all());
            return (new DivisionResource($division))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('UpdateDivision>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $check = $this->divisionService->checkPosition($id);
            if($check)
            {
                return response()->json([
                    'error' => 'You don\'t delete Division.Because It has position!'], 404);
            }
            $this->divisionService->deleteDivision($id);
            return response(null,200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('DeleteDivision>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllDivision()
    {
        $divisions = $this->divisionService->getAll();
        return new DivisionResource($divisions);
    }

    public function postSearchDivision(Request $request)
    {
        try {
            $request->validate([
                'per_page' => 'numeric|min:1|max:5'
            ]);
            $per_page = $request->input('per_page',5);
            $divisions = $this->divisionService->postSearchDivision($request->all(),$per_page);
            
            return (new DivisionResource($divisions))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
 
            return $message;
        }
    }

    public function getAllDivisionNoCondition()
    {
        $divisions = $this->divisionService->getAllDivisionNoCondition();
        return new DivisionResource($divisions);
    }

    public function postSearchDivisionNoPaginate(Request $request)
    {
        try {
            $position_division = $this->divisionService->postSearchDivisionNoPaginate($request->all());
            
            return (new DivisionResource($position_division))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
 
            return $message;
        }
    }
}
