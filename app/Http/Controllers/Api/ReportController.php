<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DateRequest;
use App\Http\Requests\Report2Request;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Http\Resources\UserResource;
use App\Http\Services\ManagerDivisionService;
use App\Http\Services\PositionDivisionService;
use App\Http\Services\ReportService;
use App\Http\Services\UserService;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SearchReportRequest;

class ReportController extends Controller
{
    protected $reportService;
    protected $positionDivisionService;
    protected $userService;
    protected $managerDivisionService;

    public function __construct(
        ReportService $reportService,
        PositionDivisionService $positionDivisionService,
        UserService $userService,
        ManagerDivisionService $managerDivisionService
    ) {
        $this->reportService = $reportService;
        $this->positionDivisionService = $positionDivisionService;
        $this->userService = $userService;
        $this->managerDivisionService = $managerDivisionService;
    }

    public function getDivisionReports()
    {

    }


    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $id = $request->id;

        $reports = $this->reportService->getReportByUser($id, $per_page);

        return new ReportResource($reports);
    }

    public function getAllReport()
    {
        $reports = $this->reportService->getAllReport();

        return new ReportResource($reports);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(ReportRequest $request)
    {

        $data = [
            'user_id' => $request->user_id,
            'assign_to' => $request->assign_to,
            'title' => $request->title,
            'content' => $request->content,
            'status' => config('common.status_report.waiting')
        ];
        $storeReport = $this->reportService->storeReportUser($data);
        $result = new ReportResource($storeReport);

        return $result;
    }


    // public function getReportUser($userId)
    // {
    //     $userReports = $this->reportService->getReportsUser($userId);
    //     $result = new ReportResource($userReports);

    //     return $result;
    // }

    public function edit($id)
    {
        $userReport = $this->reportService->findReportUser($id);
        $result = new ReportResource($userReport);

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Report2Request $request, $id)
    {
        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        $report = $this->reportService->getStatusReport($id);
        $statusDB = $report[0]->status;
        $statusAccept = config('common.status_report.accept');
        $statusReject = config('common.status_report.reject');
        if ($statusDB == $statusAccept || $statusDB == $statusReject) {
            if ($statusDB == 1) {
                return response()->json(['message' => 'Manager accepted of your report']);
            }
            if ($statusDB == -1) {
                return response()->json(['message' => 'Manager refused of your report']);
            }
        } else {
            $updateReport = $this->reportService->updateReportUser($id, $data);
            $result = new ReportResource($updateReport);

            return $result;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->reportService->deleteReport($id);

        return response()->json(200);
    }

    public function loadManager(Request $request)
    {
        $id = $request->id;
        $positionDivision = $this->userService->getPositionDivisionId($id);
        $division = $this->positionDivisionService->getDivisionId($positionDivision[0]->position_division_id);
        $manager = $this->managerDivisionService->getManager($division[0]->division_id);
        $user = $this->userService->getManager($manager[0]->user_id);

        return new ReportResource($user);
    }

    //get report limit 5
    public function getReportLimit()
    {
        $reports = $this->reportService->getReportLimit();
        return new ReportResource($reports);
    }

    //get report search
    public function postReportSearch(SearchReportRequest $request)
    {
        try {
            $report_search = $this->reportService->postReportSearch($request->all());
            return (new ReportResource($report_search))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::info('getReportSearch>>>>' . json_encode($e->getMessage()));
            return $message;
        }
    }

    public function searchByTitle(Request $request)
    {
        $keyword = $request->keyword;
        $id = $request->id;
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $reports = $this->reportService->searchReportByTitle($keyword, $id, $per_page);

        return new ReportResource($reports);
    }

    public function searchByDate(DateRequest $request)
    {
        $from = $request->start_date;
        $to = $request->end_date;
        $id = $request->id;
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $reports = $this->reportService->searchReportByDate($from, $to, $id, $per_page);

        return new ReportResource($reports);
    }

    public function searchReportByTitleAndDate(SearchReportRequest $request)
    {
        $keyword = $request->keyword;
        $from = $request->start_date;
        $to = $request->end_date;
        $id = $request->id;
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $reports = $this->reportService->searchReportByTitleAndDate($keyword, $from, $to, $id, $per_page);

        return new ReportResource($reports);
    }

    public function getReportOfUsersSameDivision(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $division = $this->userService->getDivisionOfUser($id);
        $position_division_id = $this->positionDivisionService->getIdDivisionPosition($division[0]->division_id);
        $users_id = $this->userService->getUserSameDivision($id,$position_division_id);
        $reports = $this->reportService->getReportUserSameDivision($users_id,$per_page);

        return new ReportResource($reports);
    }

    public function searchReportBySender(Request $request)
    {
        $keyword = $request->keyword;
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $reports = $this->reportService->searchReportBySender($keyword,$per_page);

        return new ReportResource($reports);
    }

    public function searchReportByDateSender(Request $request)
    {
        $from = $request->start_date;
        $to = $request->end_date;
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $reports = $this->reportService->searchReportByDateSender($from,$to,$per_page);
        
        return new ReportResource($reports);
    }

    public function searchReportByDateAndNameSender(Request $request)
    {
        $keyword = $request->keyword;
        $from = $request->start_date;
        $to = $request->end_date;
        $request->validate([
            'per_page' => 'numeric|min:1|max:5'
        ]);
        $per_page = $request->input('per_page', 5);
        $reports = $this->reportService->searchReportByDateAndNameSender($keyword,$from,$to,$per_page);
        
        return new ReportResource($reports);
    }
}
