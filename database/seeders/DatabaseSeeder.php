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
            BlogCategorySeeder::class,
            BlogTagSeeder::class,
            BlogPostSeeder::class,
            AppearanceOneSeeder::class,
            ProductCategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class
        ]);

    }
}
