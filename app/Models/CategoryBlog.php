<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'ord',
        'is_show',
        'is_highlight',
        'icon',
        'image',
        'name',
        'slug',
        'desc',
        'meta_image',
        'meta_title',
        'meta_desc'
    ];

    public static function boot()
    {
        parent::boot();

        // Đặt giá trị 'ord' tự động khi tạo mới
        static::creating(function ($model) {
            $parentId = $model->parent_id;

            $maxOrd = self::where('parent_id', $parentId)->max('ord');
            $model->ord = $maxOrd + 1;
        });
    }
}
