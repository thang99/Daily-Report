<?php

namespace App\Repositories\Contracts;

/**
 * DivisionRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface DivisionRepository extends BaseRepository
{
    public function getAllDivision();
    // get all not paginate
    public function getAll();
    public function checkPosition($id);
    public function createDivision($data);
    public function updateDivision($id,$data);
    public function deleteDivision($id);
    public function getDivision($id);
    public function postSearchDivision($data);
    public function getAllDivisionNoCondition();
    public function postSearchDivisionNoPaginate($data);
}
