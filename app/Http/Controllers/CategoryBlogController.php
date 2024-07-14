<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryBlog;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
    protected function updateTreeRecursive($parentId, $nodes)
    {
        foreach ($nodes as $index => $node) {
            $categoryId = $node['id'];
            $newOrd = $index + 1;

            CategoryBlog::where('id', $categoryId)->update([
                'parent_id' => $parentId,
                'ord' => $newOrd,
            ]);

            if (isset($node['children']) && count($node['children']) > 0) {
                $this->updateTreeRecursive($categoryId, $node['children']);
            }
        }
    }
    public function updateTree(Request $request)
    {
        $treeData = $request->input('treeData');

        // Sử dụng transaction để đảm bảo tính nhất quán
        DB::beginTransaction();

        try {
            // Gọi hàm đệ quy để cập nhật cây dữ liệu
            $this->updateTreeRecursive(null, $treeData);
            DB::commit();
            return response()->json(['message' => 'The article category data tree has been updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Unable to update article category tree', 'error' => $e->getMessage()], 500);
        }
    }
    function getDetailCategory($id)
    {
        try {
            $data = CategoryBlog::where('id', $id)->first();
            return response()->json($data, 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:category_blogs,slug',
        ]);




        // $categoryBlog = CategoryBlog::create($validatedData);

        // return response()->json($categoryBlog, 201);
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
