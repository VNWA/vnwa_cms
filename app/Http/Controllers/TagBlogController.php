<?php

namespace App\Http\Controllers;

use App\Models\TagBlog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TagBlogController extends Controller
{
    public function loadDataTable()
    {
        $tags = TagBlog::latest()->get();
        return response()->json($tags, 200);
    }
    public function checkSlug(Request $request)
    {
        $slug = $request->input('value');
        $id = $request->input('id');

        if (!$id) {
            $category = TagBlog::where('slug', $slug)->exists();

            if ($category) {
                return response()->json(['type' => 'error', 'message' => 'Slug already exists.'], 500);
            }
        } else {

            $category = TagBlog::where('id', '!=', $id)->where('slug', $slug)->exists();
            if ($category) {
                return response()->json(['type' => 'error', 'message' => 'Slug already exists.'], 500);
            }
        }
        return response()->json(['type' => 'success', 'message' => 'Slug is available.'], 200);


    }
    function create(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tag_blogs,slug',
        ]);
        $data = [];
        $data['name'] = $request->name;
        $data['slug'] = $request->slug;
        try {
            $category = TagBlog::create($data);
            return response()->json(['message' => 'Uploads Tag Blog Success'], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 507);

        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tag_blogs,slug,' . $id,
        ]);

        $data = $request->only(['name', 'slug']);

        try {
            $categoryBlog = TagBlog::findOrFail($id);
            $categoryBlog->update($data);

            return response()->json(['message' => 'Update Category Blog Success'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    function delete(Request $request)
    {

        try {
            TagBlog::whereIn('id', $request->dataId)->delete();
            return response()->json(['message' => 'Xóa dữ liệu thành công'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
