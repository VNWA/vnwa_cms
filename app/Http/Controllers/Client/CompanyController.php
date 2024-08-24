<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Models\Appearance;

class CompanyController extends Controller
{
    public function loadDataLayout()
    {

        $top_nav = Appearance::where('type', 'top_nav')->first();
        $logo = Appearance::where('type', 'logo')->first();
        $bot_search = Appearance::where('type', 'bot_search')->first();
        $footer = Appearance::where('type', 'footer')->first();
        $productCategories = $this->loadDataTreeProductCategories();

        return response()->json(['top_nav' => $top_nav->value, 'logo' => $logo->value, 'bot_search' => $bot_search->value, 'footer' => $footer->value, 'productCategories' => $productCategories], 200);
    }


    public function loadDataTreeProductCategories()
    {
        // Lấy danh mục gốc (parent_id null) đã sắp xếp theo 'ord'
        $categories = ProductCategory::whereNull('parent_id')
            ->orderBy('ord')
            ->get(['id', 'parent_id', 'name', 'ord', 'icon', 'image'])
            ->map(function ($category) {
                // Đệ quy lấy danh mục con
                $category->children = $this->getChildProductCategories($category->id);
                return $category;
            });
        return $categories;
    }

    // Đệ quy lấy danh mục con
    protected function getChildProductCategories($parentId)
    {
        // Lấy danh mục con của $parentId đã sắp xếp theo 'ord'
        $children = ProductCategory::where('parent_id', $parentId)
            ->orderBy('ord')
            ->get(['id', 'parent_id', 'name', 'ord'])
            ->map(function ($category) {
                // Đệ quy lấy danh mục con của danh mục hiện tại
                $category->children = $this->getChildProductCategories($category->id);
                return $category;
            });

        return $children;
    }
}
