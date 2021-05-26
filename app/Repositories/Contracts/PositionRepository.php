<?php

namespace App\Repositories\Contracts;

/**
 * PositionRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface PositionRepository extends BaseRepository
{
    public function getAllPosition();
    // get all not paginate
    public function getAll();
    public function getPositionByDivision($id);
    public function getNamePosition($id);
    public function postSearchPosition($data);
    public function getAllNoPaginate();
    public function deletePosition($id);
    public function checkPositionInDivision($id);
}
