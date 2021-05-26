<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Http\Services\FeedBackService;
use Illuminate\Http\Request;
use App\Http\Services\ReportService;
use App\Models\Report;

class ManagerReportController extends Controller
{
    public $reportService;
    public $feedbackService;

    public function __construct(ReportService $reportService, FeedBackService $feedbackService)
    {
        $this->reportService = $reportService;
        $this->feedbackService = $feedbackService;
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
        $per_page = $request->input('per_page', 5);

        $id = $request->id;
        $reports = $this->reportService->getReportByManager($id,$per_page);
        
        return new ReportResource($reports);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userReport = $request->user_report_id;
        $userFeedBack = $request->user_feedback_id;
        $data = array('status' => $request->status);
        $report = $this->reportService->changeStatus($id, $userReport, $userFeedBack, $data);

        // return (new ReportResource($report))->response()->getStatusCode(200);
        return new ReportResource($report);
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
    }

    public function filterByDay(Request $request)
    {
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $id = $request->id;
        $data = $request->keyword;

        $reports = $this->reportService->filterByDay($data,$id,$per_page);

        return new ReportResource($reports);
    }

    public function filterByMonth(Request $request)
    {
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $id = $request->id;
        $data = $request->keyword;
        $reports = $this->reportService->filterByMonth($data,$id,$per_page);

        return new ReportResource($reports);
    }

    public function filterAll(Request $request)
    {
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $id = $request->id;
        $data1 = $request->keyword1;
        $data2 = $request->keyword2;
        $reports = $this->reportService->filterALl($data1,$data2,$id,$per_page);

        return new ReportResource($reports);
    }

    public function feedback(Request $request)
    {
        $data = [
            'from' => $request->id_manager,
            'to' => $request->id_user,
            'report_id' => $request->id_report,
            'message' => $request->message,
        ];

        $feedback = $this->feedbackService->storeFeedBack($data);
        //  return new ReportResource($feedback);
    }
}
