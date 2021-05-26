<?php

namespace App\Repositories\Contracts;

/**
 * ReportRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface ReportRepository extends BaseRepository
{
    public function getReportByManager($id);
    public function filterByDay($data, $id);
    public function filterByMonth($data, $id);
    public function filterAll($data1,$data2,$id);
    public function getStatusReport($id);
    public function getReportLimit();
    public function postReportSearch($data);
    public function searchReportByTitle($data,$id);
    public function searchReportByDate($from,$to,$id);
    public function searchReportByTitleAndDate($data,$from,$to,$id);

    /**
     *
     * Get report of user.
     *
     * @param $id
     * @return mixed
     */
    public function getReportUserWhere($userId);

    /**
     * Find Report by id
     *
     * @param $id
     * @return mixed
     */
    public function findReportWhere($id);
    public function getReportByUser($id);
    public function getReportUserSameDivision($id);
    public function searchReportBySender($data);
    public function searchReportByDateSender($from,$to);
    public function searchReportByDateAndNameSender($data,$from,$to);
}
