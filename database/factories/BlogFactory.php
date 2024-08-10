<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition()
    {
        return [
            'banner_image' => $this->faker->imageUrl(),
            'image' => $this->faker->imageUrl(),
            'is_show' => 1,
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'desc' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(3, true),
            'author_id' => $this->faker->randomDigitNotNull,
            'meta_image' => $this->faker->imageUrl(),
            'meta_title' => $this->faker->sentence,
            'meta_desc' => $this->faker->paragraph,
        ];
    }
}
