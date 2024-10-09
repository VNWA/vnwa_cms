<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    private $seo;

    public function __construct($seo = null)
    {
        // Thiết lập giá trị mặc định cho SEO nếu không có dữ liệu được truyền vào
        $this->seo = $seo ?: [
            'title' => 'Global Procurement Logistics Solutions Co., LTD',
            'meta_title' => 'Công ty TNHH Giải pháp Logistics Mua sắm Toàn cầu | Global Procurement Logistics Solutions Co., LTD',
            'meta_description' => 'Chúng tôi cung cấp các giải pháp logistics và mua sắm toàn cầu chuyên nghiệp, đáng tin cậy và hiệu quả. Tối ưu hóa chuỗi cung ứng với Global Procurement Logistics Solutions Co., LTD.',
            'meta_keywords' => 'Logistics, mua sắm toàn cầu, giải pháp logistics, Global Procurement Logistics, giải pháp chuỗi cung ứng',
            'meta_image' => asset('client/images/SELCO-USA-LOGO-500x51.png'),
        ];
    }

    public function viewHome()
    {
        // Nếu cần, bạn có thể ghi đè giá trị SEO ở đây, ví dụ:
        $this->seo['title'] = 'Trang Chủ';

        $banners_image = Banner::where('is_show', 1)->orderByDesc('ord')->get('image')->pluck('image');

        // Trả về dữ liệu SEO đã được thiết lập hoặc mặc định
        return Inertia::render('Client/Home', [
            'seo' => $this->seo,
            'banners_image' => $banners_image
        ]);
    }

    public function viewAbout()
    {
        return Inertia::render('Client/About');
    }
    public function viewBlogs()
    {
        return Inertia::render('Client/Home');
    }
    public function viewContact()
    {
        return Inertia::render('Client/Home');
    }
    public function viewDocuments()
    {
        return Inertia::render('Client/Home');
    }
    public function viewProducts()
    {
        $products = Product::orderByDesc('id')->get(['name', 'slug', 'images', 'sku']);
        $this->seo['title'] = 'Sản phẩm';
        return Inertia::render('Client/Products', [
            'seo' => $this->seo,
            'products' => $products,
        ]);
    }
    public function viewProductCategory($slug)
    {
        $products = Product::orderByDesc('id')->get(['name', 'slug', 'images', 'sku']);
        $this->seo['title'] = 'Sản phẩm';
        return Inertia::render('Client/Products', [
            'seo' => $this->seo,
            'products' => $products,
        ]);
    }
}
