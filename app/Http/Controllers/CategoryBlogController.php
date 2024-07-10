<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryBlog;
use Carbon\Carbon;
use Inertia\Inertia;

class CategoryBlogController extends Controller
{
    public function loadDataTable()
    {
        // Lấy danh mục gốc (parent_id null) đã sắp xếp theo 'ord'
        $categories = CategoryBlog::whereNull('parent_id')
            ->orderBy('ord')
            ->get(['id', 'parent_id', 'name', 'ord'])
            ->map(function ($category) {
                // Đệ quy lấy danh mục con
                $category->children = $this->getChildCategories($category->id);
                return $category;
            });

        return $categories;
    }

    // Đệ quy lấy danh mục con
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

    public function index()
    {
        $data = $this->loadDataTable();

        return Inertia::render('CategoryBlog', ['data' => $data]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'parent_id' => 'nullable|exists:category_blogs,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:category_blogs,slug',
            'is_show' => 'nullable|boolean',
            'is_highlight' => 'nullable|boolean',
            'icon' => 'nullable|json',
            'image' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
            'meta_image' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_desc' => 'nullable|string',
        ]);

        $categoryBlog = CategoryBlog::create($validatedData);

        return response()->json($categoryBlog, 201);
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'parent_id' => 'nullable|exists:category_blogs,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:category_blogs,slug,' . $id,
            'is_show' => 'nullable|boolean',
            'is_highlight' => 'nullable|boolean',
            'icon' => 'nullable|json',
            'image' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
            'meta_image' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_desc' => 'nullable|string',
        ]);

        $categoryBlog = CategoryBlog::findOrFail($id);

        // Cập nhật giá trị `ord` nếu cần thiết
        if ($request->has('parent_id')) {
            $newParentId = $request->input('parent_id');
            if ($categoryBlog->parent_id != $newParentId) {
                // Thiết lập lại giá trị `ord`
                $maxOrd = CategoryBlog::where('parent_id', $newParentId)->max('ord');
                $validatedData['ord'] = $maxOrd + 1;
            }
        }

        $categoryBlog->update($validatedData);

        return response()->json($categoryBlog, 200);
    }

}
