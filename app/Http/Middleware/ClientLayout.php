<?php

namespace App\Http\Middleware; // Kiểm tra đường dẫn namespace

use App\Models\Appearance;
use App\Models\Brand;
use App\Models\ProductCategory;
use Inertia\Inertia;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientLayout
{
    protected function getChildCategories($parentId)
    {
        // Lấy danh mục con của $parentId đã sắp xếp theo 'ord'
        $children = ProductCategory::where('parent_id', $parentId)
            ->orderBy('ord')
            ->get(['id', 'parent_id', 'name','slug', 'ord'])
            ->map(function ($category) {
                // Đệ quy lấy danh mục con của danh mục hiện tại
                $category->children = $this->getChildCategories($category->id);
                return $category;
            });

        return $children;
    }
    public function handle(Request $request, Closure $next): Response
    {
        $logo = Appearance::where('type', 'logo')->first();
        $footer = Appearance::where('type', 'footer')->first();
        $topNav = Appearance::where('type', 'top_nav')->first();
        $profile = Appearance::where('type', 'profile')->first();
        $product_categories = $categories = ProductCategory::whereNull('parent_id')
        ->orderBy('ord')
        ->get(['id', 'parent_id', 'name','slug', 'ord'])
        ->map(function ($category) {
            // Đệ quy lấy danh mục con
            $category->children = $this->getChildCategories($category->id);
            return $category;
        });

        $brands = Brand::orderByDesc('id')->get(['name', 'slug', 'image']);

        Inertia::share([
            'layout' => [
                'logo' => $logo ? $logo->value : [],
                'footer' => $footer ? $footer->value :  [],
                'topNav' => $topNav ? $topNav->value :  [],
                'profile' => $profile ? $profile->value :  [],
            ],
            'productCategories'=>$product_categories,
            'brands'=>$brands,
        ]);

        return $next($request);
    }
}
