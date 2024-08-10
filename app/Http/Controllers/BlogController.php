<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogWithCategory;
use App\Models\BlogWithTag;
use App\Models\CategoryBlog;
use App\Models\TagBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

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
    public function loadDataCategoriesTreeAndTags()
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
            $tags = TagBlog::get(['id', 'name']);
            return response()->json(['categories' => $categories, 'tags' => $tags], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function loadDataCategoriesAndTags()
    {
        try {
            $categories = CategoryBlog::get(['id', 'name']);
            $tags = TagBlog::get(['id', 'name']);
            return response()->json(['categories' => $categories, 'tags' => $tags], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function loadDataTable(Request $request)
    {
        // Lấy các tham số từ request
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        $sortBy = $request->get('sortBy', 'created_at');
        $sortType = $request->get('sortType', 'desc');
        $name = $request->get('name');
        $categoryIds = $request->get('categories_id', []);
        $tagIds = $request->get('tags_id', []);

        // Khởi tạo query
        $query = Blog::query();

        // Lọc theo tên blog nếu có
        if ($name) {
            $query->where('name', 'like', "%$name%");
        }

        // Lọc theo danh mục nếu có
        if (!empty($categoryIds)) {
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('category_blogs.id', $categoryIds); // Sửa chỗ này
            });
        }

        // Lọc theo thẻ nếu có
        if (!empty($tagIds)) {
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tag_blogs.id', $tagIds); // Sửa chỗ này
            });
        }

        // Sắp xếp và phân trang
        $total = $query->count();
        $blogs = $query->skip(($page - 1) * $perPage)->take($perPage)->with('categories')->with('tags')->orderBy($sortBy, $sortType)->get();

        return response()->json([
            'data' => $blogs,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage),
        ], 200);
    }
    public function showEdit($id)
    {
        $blog = Blog::with('categories')->with('tags')->find($id);
        $categoriesId = $blog->categories->pluck('id');
        $blog->categoriesId = $categoriesId;
        $tagsId = $blog->tags->pluck('id');
        $blog->tagsId = $tagsId;
        return Inertia::render('Post/Edit', ['blog' => $blog]);

    }



    function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:urls,slug',
            'image' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'desc' => 'nullable|string',
            'content' => 'nullable|string',
            'seo_meta.meta_image' => 'nullable|string',
            'seo_meta.meta_title' => 'nullable|string|max:255',
            'seo_meta.meta_desc' => 'nullable|string|max:255',
            'parentIds' => 'nullable|array',
            'parentIds.*' => 'integer|exists:category_blogs,id',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tag_blogs,id',
        ]);
        $user = $request->user();
        $data = [
            'is_show' => $request->is_show ? 1 : 0,
            'name' => $request->name,
            'slug' => $request->slug,
            'image' => $request->image,
            'banner_image' => $request->banner_image,
            'desc' => $request->desc,
            'content' => $request->content,
            'author_id' => $user->id,
            'meta_image' => $request->seo_meta['meta_image'] ?? null,
            'meta_title' => $request->seo_meta['meta_title'] ?? null,
            'meta_desc' => $request->seo_meta['meta_desc'] ?? null,
        ];

        DB::beginTransaction();

        try {
            // Tạo blog
            $blog = Blog::create($data);

            // Liên kết blog với các danh mục
            foreach ($request->parentIds as $parentId) {
                BlogWithCategory::create([
                    'blog_id' => $blog->id,
                    'category_id' => $parentId,
                ]);
            }

            // Liên kết blog với các thẻ
            foreach ($request->tags as $tag) {
                BlogWithTag::create([
                    'blog_id' => $blog->id,
                    'tag_id' => $tag,
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Create Blog Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error($th);

            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    function update(Request $request, $id)
    {
        $blog = Blog::find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:urls,slug,' . $blog->url->id,
            'image' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'desc' => 'nullable|string',
            'content' => 'nullable|string',
            'seo_meta.meta_image' => 'nullable|string',
            'seo_meta.meta_title' => 'nullable|string|max:255',
            'seo_meta.meta_desc' => 'nullable|string|max:255',
            'parentIds' => 'nullable|array',
            'parentIds.*' => 'integer|exists:category_blogs,id',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tag_blogs,id',
        ]);
        $user = $request->user();
        $data = [
            'is_show' => $request->is_show ? 1 : 0,
            'name' => $request->name,
            'slug' => $request->slug,
            'image' => $request->image,
            'banner_image' => $request->banner_image,
            'desc' => $request->desc,
            'content' => $request->content,
            'author_id' => $user->id,
            'meta_image' => $request->seo_meta['meta_image'] ?? null,
            'meta_title' => $request->seo_meta['meta_title'] ?? null,
            'meta_desc' => $request->seo_meta['meta_desc'] ?? null,
        ];

        DB::beginTransaction();

        try {
            // Tạo blog
            BlogWithCategory::where('blog_id', $id)->delete();
            BlogWithTag::where('blog_id', $id)->delete();
            // Liên kết blog với các danh mục
            foreach ($request->parentIds as $parentId) {
                BlogWithCategory::create([
                    'blog_id' => $id,
                    'category_id' => $parentId,
                ]);
            }

            // Liên kết blog với các thẻ
            foreach ($request->tags as $tag) {
                BlogWithTag::create([
                    'blog_id' => $id,
                    'tag_id' => $tag,
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Update Blog Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error($th);

            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
