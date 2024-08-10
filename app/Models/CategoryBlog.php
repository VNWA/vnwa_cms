<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Url;

class CategoryBlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'ord',
        'is_show',
        'is_highlight',
        'image',
        'name',
        'slug',
        'desc',
        'meta_image',
        'meta_title',
        'meta_desc',
        'icon'
    ];

    protected $casts = [
        'icon' => 'array', // Chuyển các trường JSON thành mảng
    ];

    protected static function boot()
    {
        parent::boot();

        // Tạo ord khi tạo mới
        static::creating(function ($categoryBlog) {
            $parentId = $categoryBlog->parent_id;
            $maxOrd = self::where('parent_id', $parentId)->max('ord');
            $categoryBlog->ord = $maxOrd + 1;
        });

        static::created(function ($categoryBlog) {
            $categoryBlog->url()->create([
                'slug' => $categoryBlog->slug,
                'model_type' => get_class($categoryBlog),
                'model_id' => $categoryBlog->id
            ]);
        });

        static::updated(function ($categoryBlog) {
            $categoryBlog->url()->update([
                'slug' => $categoryBlog->slug
            ]);
        });

        static::deleted(function ($categoryBlog) {
            $categoryBlog->url()->delete();
        });
    }

    public function url()
    {
        return $this->morphOne(Url::class, 'model');
    }
}
