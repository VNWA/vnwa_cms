<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_image',
        'image',
        'is_show',
        'name',
        'slug',
        'desc',
        'content',
        'author_id',
        'meta_image',
        'meta_title',
        'meta_desc'
    ];

    protected static function boot()
    {
        parent::boot();

        // Sự kiện khi tạo mới
        static::created(function ($blog) {
            $blog->url()->create([
                'slug' => $blog->slug,
                'model_type' => get_class($blog),
                'model_id' => $blog->id
            ]);
        });

        // Sự kiện khi cập nhật
        static::updated(function ($blog) {
            $blog->url()->update([
                'slug' => $blog->slug
            ]);
        });

        // Sự kiện khi xóa
        static::deleted(function ($blog) {
            $blog->url()->delete();
        });
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryBlog::class, 'blog_with_categories', 'blog_id', 'category_id')
                    ->join('category_blogs as cb', 'cb.id', '=', 'blog_with_categories.category_id') // Sử dụng alias 'cb'
                    ->select('cb.id', 'cb.name', 'cb.slug'); // Chọn các trường từ bảng alias 'cb'
    }


    public function tags()
    {
        return $this->belongsToMany(TagBlog::class, 'blog_with_tags', 'blog_id', 'tag_id');
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
