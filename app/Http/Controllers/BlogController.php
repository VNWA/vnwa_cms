<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function loadDataTable()
    {
        $blog = Blog::latest()->get();
        return response()->json($blog, 200);
    }

}
