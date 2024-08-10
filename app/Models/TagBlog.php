<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagBlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        // Sự kiện khi tạo mới
        static::created(function ($tagBlog) {
            $tagBlog->url()->create([
                'slug' => $tagBlog->slug,
                'model_type' => get_class($tagBlog),
                'model_id' => $tagBlog->id
            ]);
        });

        // Sự kiện khi cập nhật
        static::updated(function ($tagBlog) {
            $tagBlog->url()->update([
                'slug' => $tagBlog->slug
            ]);
        });

        // Sự kiện khi xóa
        static::deleted(function ($tagBlog) {
            $tagBlog->url()->delete();
        });
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_with_tags', 'tag_id', 'blog_id');
    }

    public function url()
    {
        return $this->morphOne(Url::class, 'model');
    }
}
