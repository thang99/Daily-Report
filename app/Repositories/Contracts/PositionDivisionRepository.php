<?php

namespace App\Repositories\Contracts;

/**
 * PositionDivisionRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface PositionDivisionRepository extends BaseRepository
{
    public function getAllPositionDivision();
    public function CheckPositionExist($data);
    public function getPositionByDivision($id);
    public function getPositionBySearch($id,$data);
    public function getAllPositionNoPaginate($id);
    public function postSearchNoPaginate($id,$data);
    
    public function getDivisionId($id);
    public function getIdDivisionPosition($id);
    public function getPositionDivisionId($data1,$data2);
    public function getPositionId($id);


}
