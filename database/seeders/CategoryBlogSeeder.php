<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryBlog;
use App\Models\ListSlug;
use Illuminate\Support\Str;
class CategoryBlogSeeder extends Seeder
{
    public function run()
    {
        CategoryBlog::factory()
            ->count(10)
            ->create()
            ->each(function ($categoryBlog) {
                // Tạo ListSlug cho mỗi CategoryBlog
                ListSlug::create([
                    'slug' => Str::slug($categoryBlog->name),
                    'model_type' => CategoryBlog::class,
                    'model_id' => $categoryBlog->id,
                ]);

                // Tạo 5 danh mục con cho mỗi danh mục cha
                CategoryBlog::factory()
                    ->count(5)
                    ->create(['parent_id' => $categoryBlog->id])
                    ->each(function ($subCategory) use ($categoryBlog) {
                    // Cập nhật giá trị 'ord' cho danh mục con
                    $maxOrd = CategoryBlog::where('parent_id', $subCategory->parent_id)->max('ord');
                    $subCategory->ord = $maxOrd + 1;
                    $subCategory->save();

                    // Tạo ListSlug cho mỗi CategoryBlog con
                    ListSlug::create([
                        'slug' => Str::slug($subCategory->name),
                        'model_type' => CategoryBlog::class,
                        'model_id' => $subCategory->id,
                    ]);
                });

                // Cập nhật giá trị 'ord' cho danh mục cha
                $maxOrd = CategoryBlog::whereNull('parent_id')->max('ord');
                $categoryBlog->ord = $maxOrd + 1;
                $categoryBlog->save();
            });
    }
}
