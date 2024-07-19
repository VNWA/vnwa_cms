<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagBlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_with_tags', 'tag_id', 'blog_id');
    }
}
