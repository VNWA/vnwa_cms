<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    protected $fillable = ['slug', 'model_id', 'model_type'];

    public function model()
    {
        return $this->morphTo();
    }
}
