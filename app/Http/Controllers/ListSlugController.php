<?php

namespace App\Http\Controllers;

use App\Models\CategoryBlog;
use App\Models\ListSlug;
use Illuminate\Http\Request;

class ListSlugController extends Controller
{
    /**
     * Check the slug and determine the corresponding model to retrieve data and return the appropriate view.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\View
     */

    function checkSlug(Request $request)
    {
        if ($request->type === 'create') {
            $listSlug = ListSlug::where('slug', $request->value)->exists();
            if ($listSlug) {
                return response()->json(['type' => 'error', 'message' => 'Slug already exists.'], 500);
            }
        } else if ($request->type === 'edit') {
            $listSlug = ListSlug::where('model_type', $request->model)
                ->where('model_id', '!=', $request->id)
                ->where('slug', $request->value)
                ->exists();
            if ($listSlug) {
                return response()->json(['type' => 'error', 'message' => 'Slug already exists.'], 500);
            }
        }
        return response()->json(['type' => 'success', 'message' => 'Slug is available.'], 200);
    }
    public function check($slug)
    {
        // Tìm kiếm ListSlug với slug nhất định
        $listSlug = ListSlug::where('slug', $slug)->first();

        if (!$listSlug) {
            abort(404); // Nếu không tìm thấy, trả về 404
        }

        // Tùy thuộc vào model_type, lấy model tương ứng
        switch ($listSlug->model_type) {
            case CategoryBlog::class:
                $model = CategoryBlog::findOrFail($listSlug->model_id);
                return view('category_blog.show', compact('model'));
            // Các case khác có thể thêm tại đây cho các model khác
            default:
                abort(404); // Nếu không tìm thấy model_type, trả về 404
        }
    }
}
