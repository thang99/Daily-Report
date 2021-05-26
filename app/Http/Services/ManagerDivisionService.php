<?php

namespace App\Http\Services;


use App\Repositories\Contracts\ManagerDivisionRepository;


class ManagerDivisionService
{
    public $managerDivisionRepository;

    public function __construct(ManagerDivisionRepository $managerDivisionRepository)
    {
        $this->managerDivisionRepository = $managerDivisionRepository;
    }

    public function getManager($id)
    {
        try {
            $result = $this->managerDivisionRepository->getManager($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getDivision($id) 
    {
        try {
            $result = $this->managerDivisionRepository->getDivision($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

}