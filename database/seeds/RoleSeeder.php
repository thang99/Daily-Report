<?php

use Illuminate\Database\Seeder;
use App\Http\Services\RoleService;

class RoleSeeder extends Seeder
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }


    public function run()
    {
        $admin = config('common.role_user.admin');
        $user = config('common.role_user.user');
        $manager = config('common.role_user.manager');
        $data = [$admin, $user, $manager];

        $result = $this->roleService->createNewRole($data);

        return $result;
    }
}
