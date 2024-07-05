<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryBlog;
use Carbon\Carbon;
use Inertia\Inertia;

class CategoryBlogController extends Controller
{
    public function index(){
    $data = [];

    return Inertia::render('CategoryBlog', ['data' => $data]);

   }
}
