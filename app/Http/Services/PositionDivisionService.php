<?php
namespace App\Http\Services;

use Exception;
use App\Repositories\Contracts\PositionDivisionRepository;

class PositionDivisionService
{
    public $positionDivisionRepository;

    public function __construct(
        PositionDivisionRepository $positionDivisionRepository
    )
    {
        $this->positionDivisionRepository = $positionDivisionRepository;
    }

    // create a position-division
    public function createPositionDivision($data)
    {
        try {
            $result = $this->positionDivisionRepository->create($data);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //check position exist in division
    public function CheckPosition($data)
    {
        try {
            $result = $this->positionDivisionRepository->CheckPositionExist($data);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //get all position by division
    public function getPositionByDivision($id)
    {
        try {
            $result = $this->positionDivisionRepository->getPositionByDivision($id);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function deletePositionDivision($id)
    {
        try {
            $result = $this->positionDivisionRepository->delete($id);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getDivisionId($id)
    {
        try {
            $result = $this->positionDivisionRepository->getDivisionId($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
        
    }

    public function getIdDivisionPosition($id)
    {
        try {
            $result = $this->positionDivisionRepository->getIdDivisionPosition($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getPositionDivisionId($data1,$data2)
    {
        try {
            $result = $this->positionDivisionRepository->getPositionDivisionId($data1,$data2);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }
    
    public function getPositionId($id)
    {
        try {
            $result = $this->positionDivisionRepository->getPositionId($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
        
    }

    public function getPositionBySearch($id,$data)
    {
        try {
            $result = $this->positionDivisionRepository->getPositionBySearch($id,$data);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getAllPositionNoPaginate($id)
    {
        try {
            $result = $this->positionDivisionRepository->getAllPositionNoPaginate($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function postSearchNoPaginate($id,$data)
    {
        try {
            $result = $this->positionDivisionRepository->postSearchNoPaginate($id,$data);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }
}
