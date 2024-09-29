<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $users = [
            [
                'name' => 'Admin',
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => 'Naqshzari123@',
                'email' => 'admin@gmail.com'
            ]
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'role' => $user['role'],
                'email_verified_at' => $user['email_verified_at'],
                'password' => $user['password'],
                'email' => $user['email'],
            ]);
        }
    }
}
