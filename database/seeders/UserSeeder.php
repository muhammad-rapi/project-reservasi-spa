<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "fullname" => "Muhammad Rafi",
                "email" => "muhammadrafi@spa.com",
                "username" => "muhammadrafi",
                "phone_number" => "+628212139102",
                "password" => Hash::make('password'),
                "role" => User::ADMIN,
                "gender" => User::PRIA_GENDER,
                "is_active" => true
            ]
        ];

        foreach ($data as $d) {
            \App\Models\User::create($d);
        }
    }
}
