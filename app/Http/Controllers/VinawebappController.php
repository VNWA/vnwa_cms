<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Product;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class VinawebappController extends Controller
{
    public function viewSiteMap()
    {


        $sitemaps = [];
        $sitemaps[] = url('/');
        $sitemaps[] = url('/about-us');
        $sitemaps[] = url('/products');
        $sitemaps[] = url('/brands');
        $products = Product::orderBy('updated_at', 'desc')->get(['slug']);

        foreach ($products as $product) {
            $sitemaps[] = route('Client.Product.Detail', $product->slug);
        }

        $blogs = BlogPost::orderBy('updated_at', 'desc')->get(['slug']);

        foreach ($blogs as $value) {
            $sitemaps[] = route('Client.BlogPost.Detail', $value->slug);
        }
        $brands = Brand::orderBy('updated_at', 'desc')->get(['slug']);

        foreach ($brands as $value) {
            $sitemaps[] = route('Client.Brand.Products', $value->slug);
        }
        return response()->view('sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
    }
    function changeStatus(Request $request)
    {
        DB::table($request->tb)
            ->where('id', $request->id)
            ->update(['is_show' => DB::raw('IF(is_show = 1, 0, 1)')]);
        return response()->json('Oke');
    }
    function changeHighlight(Request $request)
    {
        DB::table($request->tb)
            ->where('id', $request->id)
            ->update(['highlight' => $request->highlight]);
        return response()->json('Oke');
    }


    function changeORD(Request $request)
    {
        DB::table($request->tb)
            ->where('id', $request->id)
            ->update(['ord' => $request->value]);
        return response()->json('Update ORD Success');
    }


}
