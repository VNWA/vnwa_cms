<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CategoryBlog;
use Illuminate\Support\Str;

class CategoryBlogFactory extends Factory
{
    protected $model = CategoryBlog::class;

    public function definition()
    {
        return [
            'parent_id' => null, // Sẽ cập nhật sau
            'ord' => 0, // Sẽ cập nhật sau
            'is_show' => $this->faker->boolean,
            'is_highlight' => $this->faker->boolean,
            'icon' => [],
            'image' => $this->faker->imageUrl,
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug,
            'desc' => $this->faker->paragraph,
            'meta_image' => $this->faker->imageUrl,
            'meta_title' => $this->faker->sentence,
            'meta_desc' => $this->faker->paragraph,
        ];
    }
}

