<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Admin account
        User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('123456789'),
            'is_admin' => true,  // Set this to true for admin user
        ]);

        // Default user account
        User::create([
            'name' => 'Taha',
            'email' => 'taha@gmail.com',
            'password' => Hash::make('123456789'),
            'is_admin' => false,  // Default user, not an admin
        ]);
    }
}
