<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        if (Auth::check()) {
            $id = Auth::id();

            return view('user.report.index', compact('id'));
        } else {

            return view('errors.403');
        }
    }

    public function edit($id)
    {
        $report = $this->reportService->findReportUser($id);
        if(isset($report)){
      
        $statusAccept = config('common.status_report.accept');
        $statusReject = config('common.status_report.reject');

        return view('user.report.edit', compact('report'));
        }else{
            return redirect()->route('user-reports.index');
        }
    }

    public function show($id)
    {
        $report = $this->reportService->findReportUser($id);

        return view('user.report.show',compact('report'));
    }

    public function showReportDivision()
    {
        if (Auth::check()) {
            $id = Auth::id();

            return view('user.report.reportdivision', compact('id'));
        } else {

            return view('errors.403');
        }
    }
}
