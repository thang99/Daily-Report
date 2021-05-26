<?php

namespace App\Http\Services;


use App\Repositories\Contracts\ReportRepository;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Support\Facades\Log;

class ReportService
{
    public $reportRepository;
    public $userRepository;

    public function __construct(ReportRepository $reportRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->reportRepository = $reportRepository;
    }

    public function getReportByManager($id)
    {
        try {
            $result = $this->reportRepository->getReportByManager($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }

    }

    public function getAllReport()
    {
        $result = $this->reportRepository->all();

        return $result;
    }

    public function filterByDay($data, $id)
    {
        try {
            $result = $this->reportRepository->filterByDay($data, $id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }

    }

    public function filterByMonth($data, $id)
    {
        try {
            $result = $this->reportRepository->filterByMonth($data, $id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }

    }

    public function filterAll($data1, $data2, $id)
    {
        try {
            $result = $this->reportRepository->filterAll($data1, $data2, $id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }

    }


    public function changeStatus($id, $userReport, $userFeedBack, $data)
    {
        try {
            $status = $data['status'];
            if ($status === config('common.status_report.accept')) {
                $message = ' has accept your report';
            }
            if ($status === config('common.status_report.reject')) {
                $message = ' has reject your report';
            }
            $report = $this->reportRepository->update($id, $data);
            if ($report) {
                $user = $this->userRepository->find($userFeedBack);
                $url = '/user-reports/list';
                $dataNotify = [
//                    'avatar' => $user->avatar,
                    'title' => $user->name,
                    'message' => $user->name . $message,
                    'id' => $userReport,
                    'url' => $url,
                ];
                $this->userRepository->sendNotificationMessage($dataNotify, $userReport);
            }

            return $report;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }

    }

    public function getReportsUser($userId)
    {

        try {
            if (!empty($userId)) {
                $result = $this->reportRepository->getReportUserWhere($userId);

            }

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function findReportUser($id)
    {
        try {
            if (!empty($id)) {
                $result = $this->reportRepository->findReportWhere($id);
            }

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function storeReportUser($data)
    {
        try {

            if (!empty($data)) {
                $result = $this->reportRepository->create($data);

            }
            if ($result) {

                $user = $this->userRepository->find($result->user_id);
                $url = '/reports';
                $dataNotify = [
//                    'avatar' => $user->avatar,
                    'title' => $user->name,
                    'message' => $user->name . ' has sent you new report',
                    'id' => $result->user_id,
                    'url' => $url
                ];
                $resultNotify = $this->userRepository->sendNotificationMessage($dataNotify, $result->assign_to);
                $dataResult = ['message' => 'Create Success', 'status' => 200];
            }

            return $dataResult;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function updateReportUser($id, $data)
    {
        try {
            if (!empty($data)) {
                $result = $this->reportRepository->update($id, $data);
            }
            if ($result) {
                $dataResult = ['message' => 'Update Success', 'status' => 200];
            }

            return $dataResult;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getReportByUser($id)
    {
        try {
            $result = $this->reportRepository->getReportByUser($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }

    }

    public function deleteReport($id)
    {
        try {
            $result = $this->reportRepository->delete($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }

    }

    public function getReportUserWhere($userId)
    {
        try {
            $result = $this->reportRepository->getReportUserWhere($userId);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }

    }

    public function getStatusReport($id)
    {
        try {
            $result = $this->reportRepository->getStatusReport($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    // limit report
    public function getReportLimit()
    {
        try {
            $result = $this->reportRepository->getReportLimit();

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    // search report admin
    public function postReportSearch($data)
    {
        try {
            $result = $this->reportRepository->postReportSearch($data);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function searchReportByTitle($data, $id)
    {
        try {
            $result = $this->reportRepository->searchReportByTitle($data, $id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function searchReportByDate($from, $to, $id)
    {
        try {
            $result = $this->reportRepository->searchReportByDate($from, $to, $id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function searchReportByTitleAndDate($data, $from, $to, $id)
    {
        try {
            $result = $this->reportRepository->searchReportByTitleAndDate($data, $from, $to, $id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getReportUserSameDivision($id)
    {
        try {
            $result = $this->reportRepository->getReportUserSameDivision($id);
            
            return $result;
        } catch(\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function searchReportBySender($data)
    {
        try {
            $result = $this->reportRepository->searchReportBySender($data);
            
            return $result;
        } catch(\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function searchReportByDateSender($from,$to)
    {
        try {
            $result = $this->reportRepository->searchReportByDateSender($from,$to);
            
            return $result;
        } catch(\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function searchReportByDateAndNameSender($data,$from,$to)
    {
        try {
            $result = $this->reportRepository->searchReportByDateAndNameSender($data,$from,$to);
            
            return $result;
        } catch(\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }
}

