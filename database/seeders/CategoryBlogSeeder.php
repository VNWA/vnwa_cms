<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryBlog;

class CategoryBlogSeeder extends Seeder
{
    public function run()
    {
        // Tạo 10 danh mục cha
        CategoryBlog::factory()->count(10)->create()->each(function ($category) {
            // Tạo 5 danh mục con cho mỗi danh mục cha
            CategoryBlog::factory()->count(5)->create(['parent_id' => $category->id])->each(function ($subCategory) {
                // Cập nhật giá trị 'ord' cho danh mục con
                $maxOrd = CategoryBlog::where('parent_id', $subCategory->parent_id)->max('ord');
                $subCategory->ord = $maxOrd + 1;
                $subCategory->save();
            });

            // Cập nhật giá trị 'ord' cho danh mục cha
            $maxOrd = CategoryBlog::whereNull('parent_id')->max('ord');
            $category->ord = $maxOrd + 1;
            $category->save();
        });
    }
}
