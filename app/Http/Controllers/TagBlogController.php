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

    function create(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:urls,slug',
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
        $tagBlog = TagBlog::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:urls,slug,' . $tagBlog->url->id,
        ]);

        $data = $request->only(['name', 'slug']);

        try {
            $tagBlog = TagBlog::findOrFail($id);
            $tagBlog->update($data);

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
