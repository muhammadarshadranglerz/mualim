<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_access',
            ],
            [
                'id'    => 3,
                'title' => 'role_access',
            ],
            [
                'id'    => 4,
                'title' => 'user_create',
            ],
            [
                'id'    => 5,
                'title' => 'user_edit',
            ],
            [
                'id'    => 6,
                'title' => 'user_show',
            ],
            [
                'id'    => 7,
                'title' => 'user_delete',
            ],
            [
                'id'    => 8,
                'title' => 'user_access',
            ],
            [
                'id'    => 14,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
