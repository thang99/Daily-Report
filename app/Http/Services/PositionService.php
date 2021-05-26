<?php
namespace App\Http\Services;

use Exception;
use App\Repositories\Contracts\PositionRepository;
use GuzzleHttp\Psr7\Request;

class PositionService
{
    public $positionRepository;

    public function __construct(
        PositionRepository $positionRepository
    )
    {
        $this->positionRepository = $positionRepository;
    }

    //get all position
    public function getAllPaginate()
    {
        try {
            $result = $this->positionRepository->getAllPosition();
            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getAll()
    {
        try {
            $result = $this->positionRepository->getAll();

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    // create a position 
    public function createPosition($data)
    {
        try {
            $data['status'] == 'false' ? 0 : 1;
            $result = $this->positionRepository->create($data);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //find a position
    public function findPosition($id)
    {
        try {
            $result = $this->positionRepository->find($id);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    // update a po
    public function updatePosition($id, array $data)
    {
        try {
            $data['status'] == 'false' ? 0 : 1;
            $result = $this->positionRepository->update($id, $data);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //delete a position
    public function deletePosition($id)
    {
        try {
            $result = $this->positionRepository->deletePosition($id);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getPositionByDivision($id)
    {
        try {
            $result = $this->positionRepository->getPositionByDivision($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getNamePosition($id)
    {
        try {
            $result = $this->positionRepository->getNamePosition($id);
        
            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
       
    }
    
    public function postSearchPosition($data)
    {
        try {
            $result = $this->positionRepository->postSearchPosition($data);
        
            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getAllNoPaginate()
    {
        try {
            $result = $this->positionRepository->getAllNoPaginate();
        
            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //check position exist in division
    public function checkPositionInDivision($id)
    {
        try {
            $result = $this->positionRepository->checkPositionInDivision($id);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }
}
