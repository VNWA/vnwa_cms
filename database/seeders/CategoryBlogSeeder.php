<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryBlog;
use Illuminate\Support\Str;

class CategoryBlogSeeder extends Seeder
{
    public function run()
    {
        CategoryBlog::factory()
            ->count(10)
            ->create()
            ->each(function ($categoryBlog) {
                CategoryBlog::factory()
                    ->count(5)
                    ->create(['parent_id' => $categoryBlog->id])
                    ->each(function ($subCategory) use ($categoryBlog) {
                        // Cập nhật giá trị 'ord' cho danh mục con
                        $maxOrd = CategoryBlog::where('parent_id', $subCategory->parent_id)->max('ord');
                        $subCategory->ord = $maxOrd + 1;
                        $subCategory->save();

                    });

                // Cập nhật giá trị 'ord' cho danh mục cha
                $maxOrd = CategoryBlog::whereNull('parent_id')->max('ord');
                $categoryBlog->ord = $maxOrd + 1;
                $categoryBlog->save();
            });
    }
}
