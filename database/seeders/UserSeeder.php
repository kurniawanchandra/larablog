<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\UserType;
use App\UserStatus;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin1',
            'email' => 'admin1@gmail.com',
            'username' => 'admin 1',
            'password' => Hash::make('12345'),
            'type' => UserType::Admin,
            'status' => UserStatus::Pending
        ]);
    }
}
