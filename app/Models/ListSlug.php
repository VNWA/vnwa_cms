<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSlug extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'model_type',
        'model_id',
    ];

    // Relationship với các model khác
    public function model()
    {
        return $this->morphTo();
    }
}
