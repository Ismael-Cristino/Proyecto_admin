<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'proyectodawj2025@gmail.com'],
            [
                'name' => 'admin',
                'email' => 'proyectodawj2025@gmail.com',
                'password' => Hash::make('adminadmin'),
            ]
        );
    }
}