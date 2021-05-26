<?php
namespace App\Http\Services;

use Exception;
use App\Repositories\Contracts\DivisionRepository;

class DivisionService
{
    public $divisionRepository;

    public function __construct(
        DivisionRepository $divisionRepository
    )
    {
        $this->divisionRepository = $divisionRepository;
    }

    //get all has paginate
    public function getAllPaginate()
    {
        try {
            $result = $this->divisionRepository->getAllDivision();
            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();
            return $message;
        }
    }

    //get all 
    public function getAll()
    {
        try {
            $result = $this->divisionRepository->getAll();
            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();
            return $message;
        }
    }

     // create a division 
     public function createDivision($data)
     {
        try {
            $data['status'] == 'false' ? 0 : 1;
            $result = $this->divisionRepository->createDivision($data);
            
            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
     }
    
      //find a division
    public function findDivision($id)
    {
        try {
            $result = $this->divisionRepository->find($id);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    // update a division
    public function updateDivision($id, array $data)
    {
        try {
            $data['status'] == 'false' ? 0 : 1;
            $result = $this->divisionRepository->updateDivision($id, $data);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //delete a division
    public function deleteDivision($id)
    {
        try {
            $result = $this->divisionRepository->deleteDivision($id);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //check division has position
    public function checkPosition($id)
    {
        try {
            $result = $this->divisionRepository->checkPosition($id);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getDivision($id)
    {
        try {
            $result = $this->divisionRepository->getDivision($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function postSearchDivision($data)
    {
        try {
            $result = $this->divisionRepository->postSearchDivision($data);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getAllDivisionNoCondition()
    {
        try {
            $result = $this->divisionRepository->getAllDivisionNoCondition();

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function postSearchDivisionNoPaginate($data)
    {
        try {
            $result = $this->divisionRepository->postSearchDivisionNoPaginate($data);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }
}
