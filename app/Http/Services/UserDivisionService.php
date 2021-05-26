<?php
namespace App\Http\Services;

use Exception;
use App\Repositories\Contracts\UserDivisionRepository;


class UserDivisionService
{
    public $userDivisionRepository;

    public function __construct(UserDivisionRepository $userDivisionRepository)
    {
        $this->userDivisionRepository = $userDivisionRepository;
    }

    //get user by division
    public function getUserByDivision($search)
    {

        try {
            $result = $this->userDivisionRepository->getUserByDivision($search);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }
}
