<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Brand; // Gọi model Brand để liên kết foreign key
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $productName = $this->faker->unique()->word; // Đảm bảo tên sản phẩm duy nhất
        return [
            'images' => [
                $this->faker->imageUrl(),
                $this->faker->imageUrl(),
                $this->faker->imageUrl()
            ],
            'brand_id' => Brand::factory(), // Tạo ngẫu nhiên brand_id từ BrandFactory
            'sku' => $this->faker->unique()->numerify('SKU###'),
            'stock' => $this->faker->numberBetween(10, 100),
            'origin' => $this->faker->country(),
            'name' => $productName,
            'slug' => Str::slug($productName . '-' . $this->faker->unique()->numerify('###')), // Đảm bảo slug duy nhất
            'description' => $this->faker->paragraph(),
            'tech_info' => $this->faker->paragraph(),
            'catalogs' => [
                $this->faker->imageUrl(),
                $this->faker->imageUrl()
            ],
        ];
    }
}
