<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name'          => 'Admin',
            'last_name'          => 'Admin',
            'email'          => 'admin@example.com',
            'password'       => bcrypt('password'),
            'remember_token' => Str::random(60),
        ]);
        User::create([
            'first_name'          => 'User',
            'last_name'          => 'User',
            'email'          => 'user@example.com',
            'password'       => bcrypt('password'),
            'remember_token' => Str::random(60),
        ]);





    }
}
