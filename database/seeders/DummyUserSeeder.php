<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Admin',
                'role' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
            ], [
                'name' => 'User',
                'role' => 'user',
                'email' => 'user@gmail.com',
                'password' => bcrypt('password'),
            ]
        ];

        foreach ($userData as $user) {
            \App\Models\User::create($user);
        }
    }
}
