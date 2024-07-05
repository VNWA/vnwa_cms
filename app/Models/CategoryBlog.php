<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryBlog extends Model
{
    protected $fillable = [
        'parent_id', 'ord', 'is_show', 'is_highlight', 'name', 'slug', 'content', 'meta_image', 'meta_title', 'meta_desc'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($categoryBlog) {
            // Tìm giá trị lớn nhất hiện tại của `ord` cho các mục cùng `parent_id`
            $maxOrd = static::where('parent_id', $categoryBlog->parent_id)->max('ord');
            $categoryBlog->ord = $maxOrd + 1;
        });

        static::deleted(function ($categoryBlog) {
            // Cập nhật lại các giá trị `ord` cho các mục cùng `parent_id`
            static::where('parent_id', $categoryBlog->parent_id)
                   ->where('ord', '>', $categoryBlog->ord)
                   ->decrement('ord');
        });
    }
}
