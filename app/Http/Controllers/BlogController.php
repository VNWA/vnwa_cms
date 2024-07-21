<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CategoryBlog;
use App\Models\TagBlog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected function getChildCategories($parentId)
    {
        // Lấy danh mục con của $parentId đã sắp xếp theo 'ord'
        $children = CategoryBlog::where('parent_id', $parentId)
            ->orderBy('ord')
            ->get(['id', 'parent_id', 'name', 'ord'])
            ->map(function ($category) {
                // Đệ quy lấy danh mục con của danh mục hiện tại
                $category->children = $this->getChildCategories($category->id);
                return $category;
            });

        return $children;
    }
    public function loadDataCategoriesAndTags()
    {
        try {
            $categories = CategoryBlog::whereNull('parent_id')
                ->orderBy('ord')
                ->get(['id', 'parent_id', 'name', 'ord'])
                ->map(function ($category) {
                    // Đệ quy lấy danh mục con
                    $category->children = $this->getChildCategories($category->id);
                    return $category;
                });
            $tags = TagBlog::all();
            return response()->json(['categories' => $categories, 'tags' => $tags], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function loadDataTable()
    {
        $blog = Blog::latest()->get();
        return response()->json($blog, 200);
    }

}
