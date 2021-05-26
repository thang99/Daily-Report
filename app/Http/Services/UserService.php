<?php

namespace App\Http\Services;


use App\Repositories\Contracts\UserRepository;
use App\Models\User;
use Exception;

class UserService
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    //create user ad set role
    public function createUser($data)
    {
        try {
            $result = $this->userRepository->create($data);
            // set role
            $user = $this->userRepository->find($result->id);
            if(is_array($data['role'])) 
            {
                foreach($data['role'] as $role)
                {
                    $user->assignRole($role);
                }
            }

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $message;
        }
    }

    //update_profile user
    public function updateUser($id,$data)
    {
        try {
            $result = $this->userRepository->update($id,$data);
            // update role
            $user = $this->userRepository->find($id);
            if(is_array($data['role'])) 
            {
                //All current roles will be removed from the user and replaced by the array given
                $user->syncRoles($data['role']);
            }

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $message;
        }
    }

    //get all manager
    public function getAllManager()
    {
        try {
            $result = $this->userRepository->getAllManager();

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $message;
        }
    }

    public function getEditManager($id)
    {
        try {
            $result = $this->userRepository->getEditManager($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $message;
        }
    }
    
    public function getPositionDivisionId($id)
    {
        try {
            $result = $this->userRepository->getPositionDivisionId($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
        
    }

    public function getUserByManager($data, $id)
    {
        try {
            $result = $this->userRepository->getUserByManager($data, $id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
        
    }

    public function update($id,$data) 
    {
        try {
            $result = $this->userRepository->update($id,$data);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
        
    }

    public function getUserNoDivision()
    {
        try {
            $result = $this->userRepository->getUserNoDivision();

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
        
    }

     //get all has paginate
    public function getAllPaginate()
    {
        try {
        $result = $this->userRepository->getAllUser();

        return $result;
        } catch (Exception $e) {
        $message = $e->getMessage();
        
        return $message;
        }
    }

    //find user by id
    public function findUserAndRole($id)
    {
        try {
            $result = $this->userRepository->findUserAndRole($id);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //delete user
    public function deleteUser($id)
    {
        try {
            $result = $this->userRepository->delete($id);
            //remove all role
            $user =  $this->userRepository->find($id);
            $user->syncRoles([]);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //change pass
    public function changePass($id,$data)
    {
        try {
            $result = $this->userRepository->update($id,$data);

            return $result;
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getManager($id)
    {
        try {
            $result = $this->userRepository->getManager($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
        
    }
    public function findUser($id)
    {
        try  {
            $result = $this->userRepository->find($id);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
        
    }

    public function searchUser($data1,$data2,$data3)
    {
        try {
            $result = $this->userRepository->searchUser($data1,$data2,$data3);

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
        
    }

    public function getAllUser()
    {
        try {
            $result = $this->userRepository->all();

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
        
    }

    // get All role user
    public function getAllRoleUser()
    {
        try {
            $users = $this->userRepository->getAllRoleUser();
            
            return  $users;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //search User
    public function postUserSearch($data)
    {
        try {
            $users = $this->userRepository->postUserSearch($data);
            
            return  $users;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    //
    public function checkUserExistInPosition($id)
    {
        try {
            $users = $this->userRepository->checkUserExistInPosition($id);
            
            return  $users;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function postUserSearchPaginate($data)
    {
        try {
            $users = $this->userRepository->postUserSearchPaginate($data);
            
            return  $users;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function findPositionByUser($id)
    {
        try {
            $user = $this->userRepository->findPositionByUser($id);

            return $user;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getInfoManagerDivision($id)
    {
        try {
            $user = $this->userRepository->getInfoManagerDivision($id);

            return $user;
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }
    
    public function getDivisionOfUser($id)
    {
        try {
            $divisions = $this->userRepository->getDivisionOfUser($id);

            return $divisions;
        } catch(\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }

    public function getUserSameDivision($id,$id_pd)
    {
        try {
            $users = $this->userRepository->getUserSameDivision($id,$id_pd);

            return $users;
        } catch(\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
    }
}
