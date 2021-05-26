<?php

namespace App\Http\Services;


use App\Models\User;
use App\Repositories\Contracts\RoleRepository;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleService
{
    public $roleRepository;
    public $userRepository;

    public function __construct(RoleRepository $roleRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get all role
     *
     * @return \Illuminate\Database\Eloquent\Collection|string
     */

    public function getAllRoles()
    {
        try {
            $result = $this->roleRepository->all();

            return $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $message;
        }
    }

    /**
     * Create new role
     *
     * @param $data
     * @param $permissions
     */
    public function createNewRole($data)
    {
        try {

            DB::beginTransaction();
            for ($i = 0; $i < count($data); $i++) {
                $roleData = ['name' => $data[$i]];

                $result = self::createRoles($roleData);
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            $message = $e->getMessage();
            return $message;
        }
    }

    public function giveRoleUser()
    {
        $user = $this->userRepository->find(1);
        $user->assignRole('admin');
        $user->assignRole('user');
        $user->assignRole('manager');
    }

    public function createRoles($data)
    {
        $result = $this->roleRepository->create($data);
        return $result;
    }

    public function getRoleId($column,$data1,$data2)
    {
        $result = $this->roleRepository->getRoleId($column,$data1,$data2);

        return $result;
    }
}
