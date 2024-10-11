<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'images',
        'brand_id',
        'sku',
        'stock',
        'origin',
        'name',
        'slug',
        'description',
        'tech_info',
        'catalogs'
    ];
    protected $casts = [
        'images' => 'array', // Chuyển các trường JSON thành mảng
        'catalogs' => 'array',
    ];
    protected static function boot()
    {
        parent::boot();

        // Sự kiện khi tạo mới
        static::created(function ($product) {
            $product->url()->create([
                'slug' => $product->slug,
                'model_type' => get_class($product),
                'model_id' => $product->id
            ]);
        });

        // Sự kiện khi cập nhật
        static::updated(function ($product) {
            $product->url()->update([
                'slug' => $product->slug
            ]);
        });

        // Sự kiện khi xóa
        static::deleted(function ($product) {
            $product->url()->delete();
        });
    }

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category_assignments', 'product_id', 'product_category_id')
            ->select('product_categories.id', 'product_categories.name', 'product_categories.slug');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }


    public function url()
    {
        return $this->morphOne(Url::class, 'model');
    }
    public function getCreatedAtAttribute($value)
    {
        return $this->formatDate($value);
    }

    // Accessor cho `updated_at`
    public function getUpdatedAtAttribute($value)
    {
        return $this->formatDate($value);
    }

    // Hàm định dạng ngày giờ tùy thuộc vào điều kiện
    private function formatDate($value)
    {
        $date = Carbon::parse($value);
        if ($date->isToday()) {
            return $date->diffForHumans();
        } else {
            return $date->format('d/m/Y');
        }
    }

}
