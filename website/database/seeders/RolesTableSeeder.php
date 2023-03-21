<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'         => 1,
                'title'      => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 2,
                'title'      => 'Uploader',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 3,
                'title'      => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Role::insert($roles);
    }
}
