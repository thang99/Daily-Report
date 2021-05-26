<?php

namespace App\Repositories\Contracts;

interface ManagerDivisionRepository extends BaseRepository
{
    public function getManager($id);
    public function getDivision($id);
}