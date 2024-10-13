<?php

namespace Database\Seeders;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::create([
            'name' => 'DEV',
            'email' => 'nhatnguyen.dev.fullstack@gmail.com',
            'password' => Hash::make('dev@123'),
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@vinawebapp.com',
            'password' => Hash::make('admin@123'),
        ]);
    }
}
