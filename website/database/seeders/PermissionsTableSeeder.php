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
                'id'         => '1',
                'title'      => 'user_management_access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '2',
                'title'      => 'permission_create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '3',
                'title'      => 'permission_edit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '4',
                'title'      => 'permission_show',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '5',
                'title'      => 'permission_delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '6',
                'title'      => 'permission_access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '7',
                'title'      => 'role_create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '8',
                'title'      => 'role_edit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '9',
                'title'      => 'role_show',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '10',
                'title'      => 'role_delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '11',
                'title'      => 'role_access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '12',
                'title'      => 'user_create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '13',
                'title'      => 'user_edit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '14',
                'title'      => 'user_show',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '15',
                'title'      => 'user_delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => '16',
                'title'      => 'user_access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Permission::insert($permissions);
    }
}
