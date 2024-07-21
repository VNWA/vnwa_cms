<?php

namespace App\Models;

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
    public function categories()
    {
        return $this->belongsToMany(CategoryBlog::class, 'blog_with_categories', 'blog_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(TagBlog::class, 'blog_with_tags', 'blog_id', 'tag_id');
    }
}
