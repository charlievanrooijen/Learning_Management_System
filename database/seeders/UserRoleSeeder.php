<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        // Define the users
        $users = [
            [
                'name' => 'Charlie',
                'email' => 'charlievanrooijen@gmail.com',
                'password' => Hash::make('test'),
                'role' => 'Admin',
            ],
            [
                'name' => 'Charlie',
                'email' => 'charlievanrooijenstudent@gmail.com',
                'password' => Hash::make('test'),
                'role' => 'Student',
            ],
            [
                'name' => 'Charlie',
                'email' => 'charlievanrooijenteacher@gmail.com',
                'password' => Hash::make('test'),
                'role' => 'Teacher',
            ],
        ];

        // Create or update users
        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
