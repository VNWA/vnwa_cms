<?php

namespace App\Http\Controllers;

use App\Models\Appearance;
use App\Models\Banner;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOrder;
use Http;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;

class ClientController extends Controller
{
    private $seo;

    public function __construct($seo = null)
    {
        // Thiết lập giá trị mặc định cho SEO nếu không có dữ liệu được truyền vào
        $this->seo = $seo ?: [
            'title' => 'Chinh Phục tương lai thành công ',
            'meta_title' => 'Chinh Phục tương lai thành công | Chuyên Gia Hướng Nghiệp',
            'meta_description' => 'Tại đây, chúng tôi cam kết đồng hành cùng bạn trong hành trình chinh phục ước mơ, giúp bạn khám phá bản thân, đưa ra những lựa chọn đúng đắn và chuẩn bị sẵn sàng để bước vào một tương lai thành công! Nếu bạn cần tư vấn, đừng ngần ngại liên hệ. Hãy để chúng tôi giúp bạn “khơi dậy tiềm năng – định hướng tương lai”!',
            'meta_keywords' => 'Hướng nghiệp, xuất khẩu lao đông',
            'meta_image' => asset('client/images/SELCO-USA-LOGO-500x51.png'),
        ];
    }
    public function quoteProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^([0-9\s\-\+\(\)]*)$/',
            'product_slug' => 'required|string|max:255|alpha_dash',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
        ], [
            'required' => 'Trường :attribute là bắt buộc.',
            'string' => 'Trường :attribute phải là chuỗi.',
            'max' => [
                'string' => 'Trường :attribute không được vượt quá :max ký tự.',
            ],
            'email' => 'Địa chỉ email không hợp lệ.',
            'regex' => 'Số điện thoại không hợp lệ.',
            'alpha_dash' => 'Slug sản phẩm chỉ được chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
        ], [
            'attributes' => [
                'name' => 'Họ Và Tên',
                'phone' => 'Số điện thoại',
                'product_slug' => 'Sản Phẩm',
                'email' => 'Địa Chỉ Email',
                'message' => 'Tin Nhắn',
            ],
        ]);
        $product = Product::where('slug', $request->product_slug)->first();
        if ($product) {
            try {
                ProductOrder::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'product' => $product,
                    'email' => $request->email,
                    'message' => $request->message,
                ]);
                return response()->json(['message' => ['Đặt Hàng Thành Công']], 200);

            } catch (\Throwable $th) {
                return response()->json(['message' => ['Đặt Hàng Thất bại']], 500);

            }

        } else {
            return response()->json(['message' => ['Đặt Hàng Thất bại']], 500);

        }


    }

    public function sendTelegram($data)
    {
        $br = PHP_EOL . '  ----------------------------------   ';
        $name = PHP_EOL . 'Tên:   ' . $data['name'];

        $email = PHP_EOL . ' Email :    ' . $data['email'];

        $phone = PHP_EOL . '  Số điện thoại :  ' . $data['phone'];


        $message = PHP_EOL . '  Tin Nhắn :   ' . $data['message'];
        $text = $br . $name . $email . $phone . $message;

        $chatId = '-1002091710745';
        $tokenTe = 'bot7125079219:AAEtbvK2Yg2yqoy3s8mLcIaOSJhfffUF9Ng';
        $url = 'https://api.telegram.org/' . $tokenTe . '/sendMessage?parse_mode=html&chat_id=' . $chatId;
        $url = $url . '&text=' . urlencode($text);
        try {
            Http::timeout(-1)->get($url);
        } catch (\Throwable $th) {
            return true;
        }
        return true;

    }
    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
        ], [
            'required' => 'Trường :attribute là bắt buộc.',
            'string' => 'Trường :attribute phải là chuỗi.',
            'max' => [
                'string' => 'Trường :attribute không được vượt quá :max ký tự.',
            ],
            'email' => 'Địa chỉ email không hợp lệ.',
            'regex' => 'Số điện thoại không hợp lệ.',
        ], [
            'attributes' => [
                'name' => 'Họ Và Tên',
                'phone' => 'Số điện thoại',
                'email' => 'Địa Chỉ Email',
                'message' => 'Tin Nhắn',
            ],
        ]);
        try {
            Contact::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'message' => $request->message,
            ]);
            $this->sendTelegram([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'message' => $request->message,
            ]);
            return response()->json(['message' => ['Gửi liên hệ thành công']], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => ['Gửi liên hệ thất bại']], 500);

        }


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
        $breadcrumbs = [
            ['Về Chúng Tôi', route('Client.About')],
        ];
        $this->seo['title'] = 'Về Chúng Tôi';
        $appearance = Appearance::where('type', 'about')->first();
        $about = $appearance->value;
        return Inertia::render('Client/About', [
            'seo' => $this->seo,
            'breadcrumbs' => $breadcrumbs,
            'about' => $about['content']
        ]);
    }
    public function viewService()
    {
        $breadcrumbs = [
            ['Dịch vụ', route('Client.Service')],
        ];
        $this->seo['title'] = 'Dịch vụ';
        $appearance = Appearance::where('type', 'service')->first();
        $about = $appearance->value;
        return Inertia::render('Client/Service', [
            'seo' => $this->seo,
            'breadcrumbs' => $breadcrumbs,
            'about' => $about['content']
        ]);
    }



    protected function getChildBlogCategories($parentId)
    {
        // Lấy danh mục con của $parentId đã sắp xếp theo 'ord'
        $children = BlogCategory::where('parent_id', $parentId)
            ->orderBy('ord')
            ->get(['id', 'parent_id', 'name', 'slug', 'ord'])
            ->map(function ($category) {
                // Đệ quy lấy danh mục con của danh mục hiện tại
                $category->children = $this->getChildBlogCategories($category->id);
                return $category;
            });

        return $children;
    }
    public function viewBlogs()
    {
        $breadcrumbs = [
            ['Bài Viết', route('Client.Blogs')],
        ];
        $this->seo['title'] = 'Bài Viết';
        $blogCategories = $categories = BlogCategory::whereNull('parent_id')
            ->orderBy('ord')
            ->get(['id', 'parent_id', 'name', 'slug', 'ord'])
            ->map(function ($category) {
                // Đệ quy lấy danh mục con
                $category->children = $this->getChildBlogCategories($category->id);
                return $category;
            });
        $blogPosts = BlogPost::orderByDesc('id')->get(['name', 'slug', 'image', 'desc']);
        return Inertia::render('Client/Blogs', [
            'seo' => $this->seo,
            'breadcrumbs' => $breadcrumbs,
            'blogCategories' => $blogCategories,
            'blogPosts' => $blogPosts,
        ]);
    }
    public function viewBlogCategories($slug)
    {
        $blogCategory = BlogCategory::where('slug', $slug)->with('blogPosts:name,slug,image,desc')->first();

        $breadcrumbs = [
            ['Bài Viết', route('Client.Blogs')],
            [$blogCategory->name, route('Client.BlogCategory.Posts', $slug)],
        ];
        $this->seo['title'] = $blogCategory->name;
        $this->seo['meta_title'] = $blogCategory->name;
        $blogCategories = $categories = BlogCategory::whereNull('parent_id')
            ->orderBy('ord')
            ->get(['id', 'parent_id', 'name', 'slug', 'ord'])
            ->map(function ($category) {
                // Đệ quy lấy danh mục con
                $category->children = $this->getChildBlogCategories($category->id);
                return $category;
            });
        $blogPosts = $blogCategory->blogPosts;
        return Inertia::render('Client/Blogs', [
            'seo' => $this->seo,
            'breadcrumbs' => $breadcrumbs,
            'blogCategories' => $blogCategories,
            'blogPosts' => $blogPosts,
        ]);
    }
    public function viewBlogPostDetail($slug)
    {
        $blogPost = BlogPost::where('slug', $slug)->first();

        $breadcrumbs = [
            ['Bài Viết', route('Client.Blogs')],
            [$blogPost->name, route('Client.BlogCategory.Posts', $slug)],
        ];
        $this->seo['title'] = $blogPost->name;
        $this->seo['meta_title'] = $blogPost->meta_title || $blogPost->name;
        $this->seo['meta_description'] = $blogPost->meta_desc || $blogPost->desc;
        $this->seo['meta_image'] = $blogPost->meta_image || $blogPost->image;
        $blogCategories = $categories = BlogCategory::whereNull('parent_id')
            ->orderBy('ord')
            ->get(['id', 'parent_id', 'name', 'slug', 'ord'])
            ->map(function ($category) {
                // Đệ quy lấy danh mục con
                $category->children = $this->getChildBlogCategories($category->id);
                return $category;
            });
        return Inertia::render('Client/BlogPostDetail', [
            'seo' => $this->seo,
            'breadcrumbs' => $breadcrumbs,
            'blogCategories' => $blogCategories,
            'blogPost' => $blogPost,
        ]);
    }


    public function viewContact()
    {
        $breadcrumbs = [
            ['Liên hệ', route('Client.Contact')],
        ];
        $this->seo['title'] = 'Liên hệ';
        $this->seo['meta_title'] = 'Liên hệ';
        return Inertia::render('Client/Contact', [
            'seo' => $this->seo,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    public function viewBrands()
    {
        $breadcrumbs = [
            ['Thương hiệu', route('Client.Brands')],
        ];
        $this->seo['title'] = 'Thương hiệu';
        $this->seo['meta_title'] = 'Thương hiệu';
        return Inertia::render('Client/Brands', [
            'seo' => $this->seo,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    public function viewBrandProducts($slug)
    {
        $brand = Brand::with('products')->where('slug', $slug)->first();

        // Kiểm tra xem brand có tồn tại hay không
        if (!$brand) {
            abort(404);
        }

        // Tìm kiếm sản phẩm theo tên hoặc slug
        $productsQuery = $brand->products(); // Lấy query builder từ mối quan hệ products

        if (isset($_GET['s'])) {
            $name = $_GET['s'];
            $slug = Str::slug($name);

            // Tìm kiếm theo tên hoặc slug có chứa chuỗi tương tự
            $productsQuery->where(function ($query) use ($name, $slug) {
                $query->where('name', 'LIKE', "%$name%")
                    ->orWhere('slug', 'LIKE', "%$slug%")
                    ->orWhere('sku', 'LIKE', "%$name%");
            });
        }

        // Phân trang kết quả
        $products = $productsQuery->orderByDesc('id')->select(['name', 'slug', 'images', 'sku'])->paginate(12);

        // Cập nhật thông tin SEO
        $this->seo['title'] = $brand->name;
        $this->seo['meta_title'] = $brand->name;
        $this->seo['meta_description'] = $brand->desc ?: null;
        $this->seo['meta_image'] = $brand->image ?: null;

        // Thiết lập breadcrumbs
        $breadcrumbs = [
            ['Sản Phẩm', route('Client.Products')],
            [$brand->name, route('Client.Brand.Products', $slug)]
        ];

        return Inertia::render('Client/Products', [
            'seo' => $this->seo,
            'products' => $products,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function viewProducts()
    {
        $products = Product::query();

        if (isset($_GET['s'])) {
            $name = $_GET['s'];
            $slug = Str::slug($name);

            // Tìm kiếm theo tên hoặc slug có chứa chuỗi tương tự
            $products = $products->where(function ($query) use ($name, $slug) {
                $query->where('name', 'LIKE', "%$name%")
                    ->orWhere('slug', 'LIKE', "%$slug%")->orWhere('sku', 'LIKE', "%$name%");
            });
        }

        $products = $products->orderByDesc('id')->select(['name', 'slug', 'images', 'sku'])->paginate(perPage: 12);
        $this->seo['title'] = 'Sản phẩm';
        $this->seo['meta_title'] = 'Sản phẩm';
        $breadcrumbs = [
            ['Sản Phẩm', route('Client.Products')]
        ];
        return Inertia::render('Client/Products', [
            'seo' => $this->seo,
            'products' => $products,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    public function ViewProductDetail($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $this->seo['title'] = $product->name;
        $this->seo['meta_title'] = $product->meta_desc || $product->name;
        $this->seo['meta_description'] = $product->meta_desc || null;
        $this->seo['meta_image'] = $product->meta_image || $product->images[0];
        $breadcrumbs = [
            ['Sản Phẩm', route('Client.Products')],
            [$product->name, route('Client.Product.Detail', $slug)],
        ];
        return Inertia::render('Client/ProductDetail', [
            'seo' => $this->seo,
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    public function viewCategoryProducts($slug)
    {
        $category = ProductCategory::with('products')->where('slug', $slug)->first();

        // Kiểm tra xem category có tồn tại hay không
        if (!$category) {
            abort(404);
        }

        // Tìm kiếm sản phẩm theo tên hoặc slug
        $productsQuery = $category->products(); // Lấy query builder từ mối quan hệ products

        if (isset($_GET['s'])) {
            $name = $_GET['s'];
            $slug = Str::slug($name);

            // Tìm kiếm theo tên hoặc slug có chứa chuỗi tương tự
            $productsQuery->where(function ($query) use ($name, $slug) {
                $query->where('name', 'LIKE', "%$name%")
                    ->orWhere('slug', 'LIKE', "%$slug%")
                    ->orWhere('sku', 'LIKE', "%$name%");
            });
        }

        // Phân trang kết quả
        $products = $productsQuery->orderByDesc('id')->select(['name', 'slug', 'images', 'sku'])->paginate(12);

        // Cập nhật thông tin SEO
        $this->seo['title'] = $category->name;
        $this->seo['meta_title'] = $category->meta_title ?: $category->name;
        $this->seo['meta_description'] = $category->meta_desc ?: $category->desc;
        $this->seo['meta_image'] = $category->meta_image ?: null;

        // Thiết lập breadcrumbs
        $breadcrumbs = [
            ['Sản Phẩm', route('Client.Products')],
            [$category->name, route('Client.ProductCategory.Products', $slug)]
        ];

        return Inertia::render('Client/Products', [
            'seo' => $this->seo,
            'products' => $products,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

}
