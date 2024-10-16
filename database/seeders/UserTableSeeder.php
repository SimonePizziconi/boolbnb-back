<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => 'Test',
                'email' => 'admin@test.it',
                'password' => Hash::make('321321321')
            ],
            [
                'first_name' => 'User',
                'last_name' => 'Due',
                'email' => 'user@due.it',
                'password' => Hash::make('321321321')

            ],
            [
                'first_name' => 'User',
                'last_name' => 'Tre',
                'email' => 'user@tre.it',
                'password' => Hash::make('321321321')

            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
