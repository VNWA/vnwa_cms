<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'desc',
        'meta_image',
        'meta_title',
        'meta_desc'
    ];

    protected $casts = [
        'icon' => 'array', // Chuyển các trường JSON thành mảng
    ];

    public function listSlug()
    {
        return $this->morphOne(ListSlug::class, 'model');
    }

    protected static function boot()
    {
        parent::boot();

        // Tạo slug và ord khi tạo mới
        static::creating(function ($categoryBlog) {
            $categoryBlog->slug = self::generateUniqueSlug($categoryBlog->name);
            $parentId = $categoryBlog->parent_id;
            $maxOrd = self::where('parent_id', $parentId)->max('ord');
            $categoryBlog->ord = $maxOrd + 1;
        });

        // Cập nhật slug khi cập nhật
        static::updating(function ($categoryBlog) {
            $categoryBlog->slug = self::generateUniqueSlug($categoryBlog->name, $categoryBlog->id);
        });
    }

    // Hàm tạo slug duy nhất
    private static function generateUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);

        // Kiểm tra và chỉnh sửa nếu slug đã tồn tại
        $query = static::where('slug', $slug);
        if ($id) {
            $query->where('id', '!=', $id);
        }

        $count = $query->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1); // Thêm số đếm vào slug nếu trùng lặp
        }

        return $slug;
    }
}
