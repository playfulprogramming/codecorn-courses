<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => env('SEED_EMAIL', 'admin@admin.com'),
                'password'       => bcrypt(env('SEED_PASSWORD', 'password')),
                'remember_token' => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        User::insert($users);
    }
}
