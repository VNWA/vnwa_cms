<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoryBlogSeeder::class,
            BlogSeeder::class,
            TagBlogSeeder::class,
        ]);
        User::create([
            'name' => 'DEV',
            'email' => 'nhatnguyen.dev.fullstack@gmail.com',
            'password' => Hash::make('dev@123'),
        ]);
    }
}
