<?php

namespace Database\Factories;

use App\Models\CategoryBlog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryBlogFactory extends Factory
{
    protected $model = CategoryBlog::class;

    public function definition()
    {
        return [
            'parent_id' => null,
            'ord' => 0,
            'is_show' => 1,
            'is_highlight' => $this->faker->boolean,
            'image' => $this->faker->imageUrl(),
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'desc' => $this->faker->paragraph,
            'meta_image' => $this->faker->imageUrl(),
            'meta_title' => $this->faker->sentence,
            'meta_desc' => $this->faker->paragraph,
            'icon' => json_encode(['icon_name' => $this->faker->word, 'icon_type' => $this->faker->word])
        ];
    }
}
