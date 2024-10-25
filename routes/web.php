<?php

use App\Http\Controllers\AppearanceController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\BlogTagController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Inertia\ApiTokenController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductExcelController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\ProductOrderController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\VinawebappController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MediaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/sitemap.xml', [VinawebappController::class, 'viewSiteMap'])->name('sitemap.index');


Route::get('vnwa/', function () {
    return Inertia::render('Admin/Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/vnwa/login', function () {
    return Inertia::render('Admin/Auth/Login');
})->name('login');
Route::prefix('vnwa')
    ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {
        Route::post('/change-status', [VinawebappController::class, 'changeStatus']);
        Route::post('/change-highlight', [VinawebappController::class, 'changeHighlight']);
        Route::post('/change-ord', [VinawebappController::class, 'changeORD']);

        Route::prefix('contacts')->group(function () {
            Route::get('/load-data-table', [ContactController::class, 'loadDataTable']);
            Route::get('/', function () {
                return Inertia::render('Admin/Contact');
            })->name('Contact');
            Route::post('/delete', [ContactController::class, 'delete']);
        });

        Route::get('/check-slug/{slug}/{model_type?}/{model_id?}', [UrlController::class, 'checkSlug']);

        Route::get('/', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('dashboard');
        Route::prefix('media')->group(function () {
            Route::get('/', function () {
                return Inertia::render('Admin/Media');
            })->name('Media');

            Route::post('get-data-files', [MediaController::class, 'getDataFiles']);

            Route::post('upload-files', [MediaController::class, 'uploadFiles']);
            Route::post('create-directory', [MediaController::class, 'createDirectory']);
            Route::post('rename', [MediaController::class, 'rename']);
            Route::post('delete', [MediaController::class, 'delete']);
        });

        Route::prefix('blog')
            ->group(function () {

                Route::prefix('categories')->group(function () {
                    Route::get('/', [BlogCategoryController::class, 'index'])->name('Blog.Categories');
                    Route::get('/load-new-tree-data', [BlogCategoryController::class, 'loadNewDataTree']);

                    Route::post('/update-tree', [BlogCategoryController::class, 'updateTree']);
                    Route::get('/get-detail-category/{id}', [BlogCategoryController::class, 'getDetailCategory']);
                    Route::post('/create', [BlogCategoryController::class, 'create']);
                    Route::post('/update/{id}', [BlogCategoryController::class, 'update']);
                    Route::post('/delete/{id}', [BlogCategoryController::class, 'delete']);

                });
                Route::prefix('tags')->group(function () {
                    Route::get('/load-data-table', [BlogTagController::class, 'loadDataTable']);
                    Route::get('/', function () {
                        return Inertia::render('Admin/Blog/BlogTags');
                    })->name('Blog.Tags');
                    Route::post('/create', [BlogTagController::class, 'create']);
                    Route::post('/update/{id}', [BlogTagController::class, 'update']);
                    Route::post('/delete', [BlogTagController::class, 'delete']);
                });
                Route::prefix('posts')->group(function () {
                    Route::get('/', function () {
                        return Inertia::render('Admin/Blog/BlogPost/Show');
                    })->name('Blog.Posts');
                    Route::get('/load-data-table', [BlogPostController::class, 'loadDataTable']);
                    Route::get('/load-data-categories-tree-and-tags', [BlogPostController::class, 'loadDataCategoriesTreeAndTags']);
                    Route::get('/load-data-categories-and-tags', [BlogPostController::class, 'loadDataCategoriesAndTags']);
                    Route::get('/create', function () {
                        return Inertia::render('Admin/Blog/BlogPost/Create');
                    })->name('Blog.Posts.Create');
                    Route::post('/create', [BlogPostController::class, 'create']);
                    Route::get('/edit/{id}', [BlogPostController::class, 'showEdit'])->name('Blog.Posts.Edit');
                    Route::post('/update/{id}', [BlogPostController::class, 'update']);
                    Route::post('/delete', [BlogPostController::class, 'delete']);
                });
            });
        Route::prefix('ecommerce')
            ->group(function () {
                Route::prefix('product-categories')->group(function () {
                    Route::get('/', [ProductCategoryController::class, 'index'])->name('Ecommerce.ProductCategories');
                    Route::get('/load-new-tree-data', [ProductCategoryController::class, 'loadNewDataTree']);
                    Route::post('/update-tree', [ProductCategoryController::class, 'updateTree']);
                    Route::get('/get-detail-category/{id}', [ProductCategoryController::class, 'getDetailCategory']);
                    Route::post('/create', [ProductCategoryController::class, 'create']);
                    Route::post('/update/{id}', [ProductCategoryController::class, 'update']);
                    Route::post('/delete/{id}', [ProductCategoryController::class, 'delete']);
                });

                Route::prefix('brands')->group(function () {
                    Route::get('', [BrandController::class, 'showIndex'])->name('Ecommerce.Brand');
                    Route::post('load-data-table', [BrandController::class, 'loadDataTable']);
                    Route::get('/create', function () {
                        return Inertia::render('Admin/Ecommerce/Brand/Create');
                    })->name('Ecommerce.Brand.Create');

                    Route::post('/delete', [BrandController::class, 'delete']);
                    Route::post('/create', [BrandController::class, 'create']);

                    Route::get('/edit/{id}', [BrandController::class, 'showEdit'])->name('Ecommerce.Brand.Edit');
                    Route::post('/update/{id}', [BrandController::class, 'update']);
                });

                Route::prefix('products')->group(function () {


                    Route::get('/', function () {
                        return Inertia::render('Admin/Ecommerce/Product/Show');
                    })->name('Ecommerce.Product');

                    Route::prefix('excel')->group(function () {
                        Route::get('/import', function () {
                            return Inertia::render('Admin/Ecommerce/Product/Import');
                        })->name('Ecommerce.Product.Import');
                        Route::get('/convert', function () {
                            return Inertia::render('Admin/Ecommerce/Product/Convert');
                        })->name('Ecommerce.Product.Convert');
                        Route::get('/export-template', [ProductExcelController::class, 'export'])->name('Ecommerce.Product.ExportTemplate');
                        Route::post('/read', [ProductExcelController::class, 'read']);
                        Route::post('/import', [ProductExcelController::class, 'import']);
                    });

                    Route::get('/load-data-table', [ProductController::class, 'loadDataTable']);
                    Route::get('/load-data-categories-tree-and-brands', [ProductController::class, 'loadDataCategoriesTreeAndBrands']);
                    Route::get('/load-data-categories-and-brands', [ProductController::class, 'loadDataCategoriesAndBrands']);

                    Route::get('/create', function () {
                        return Inertia::render('Admin/Ecommerce/Product/Create');
                    })->name('Ecommerce.Product.Create');

                    Route::post('/create', [ProductController::class, 'create']);
                    Route::get('/edit/{id}', [ProductController::class, 'showEdit'])->name('Ecommerce.Product.Edit');
                    Route::post('/update/{id}', [ProductController::class, 'update']);
                    Route::post('/delete', [ProductController::class, 'delete']);
                });
                Route::prefix('orders')->group(function () {
                    Route::get('/load-data-table', [ProductOrderController::class, 'loadDataTable']);
                    Route::get('/', function () {
                        return Inertia::render('Admin/Ecommerce/ProductOrder');
                    })->name('Ecommerce.ProductOrder');
                    Route::post('/delete', [ProductOrderController::class, 'delete']);
                });


            });
        Route::prefix('banners')->group(function () {
            Route::get('', action: [BannerController::class, 'showIndex'])->name('Banner');
            Route::post('load-data-table', [BannerController::class, 'loadDataTable']);
            Route::get('/create', function () {
                return Inertia::render('Admin/Banner/Create');
            })->name('Banner.Create');

            Route::post('/delete', [BannerController::class, 'delete']);
            Route::post('/create', [BannerController::class, 'create']);

            Route::get('/edit/{id}', [BannerController::class, 'showEdit'])->name('Banner.Edit');
            Route::post('/update/{id}', [BannerController::class, 'update']);
        });
        Route::prefix('appearance')
            ->group(function () {
                Route::get('/', function () {
                    return Inertia::render('Admin/Appearance/Show');
                })->name('Appearance');
                Route::prefix('top-nav')->group(function () {
                    Route::get('/', function () {
                        return Inertia::render('Admin/Appearance/TopNav');
                    })->name('Appearance.TopNav');

                    Route::get('/load-json-data', [AppearanceController::class, 'loadJsonDataTopNav']);
                    Route::post('/update', [AppearanceController::class, 'updateTopNav']);
                });

                Route::prefix('profile')->group(function () {
                    Route::get('/', function () {
                        return Inertia::render('Admin/Appearance/Profile');
                    })->name('Appearance.Profile');

                    Route::get('/load-json-data', [AppearanceController::class, 'loadJsonDataProfile']);
                    Route::post('/update', [AppearanceController::class, 'updateProfile']);
                });

                Route::prefix('bot-search')->group(function () {
                    Route::get('/', function () {
                        return Inertia::render('Admin/Appearance/BotSearch');
                    })->name('Appearance.BotSearch');

                    Route::get('/load-json-data', [AppearanceController::class, 'loadJsonDataBotSearch']);
                    Route::post('/update', [AppearanceController::class, 'updateBotSearch']);
                });
                Route::prefix('logo')->group(function () {
                    Route::get('/', function () {
                        return Inertia::render('Admin/Appearance/Logo');
                    })->name('Appearance.Logo');

                    Route::get('/load-json-data', [AppearanceController::class, 'loadJsonDataLogo']);
                    Route::post('/update', [AppearanceController::class, 'updateLogo']);
                });

                Route::prefix('footer')->group(function () {
                    Route::get('/', function () {
                        return Inertia::render('Admin/Appearance/Footer');
                    })->name('Appearance.Footer');

                    Route::get('/load-json-data', [AppearanceController::class, 'loadJsonDataFooter']);
                    Route::post('/update', [AppearanceController::class, 'updateFooter']);
                });
                Route::prefix('about')->group(function () {
                    Route::get('/', function () {
                        return Inertia::render('Admin/Appearance/About');
                    })->name('Appearance.About');

                    Route::get('/load-json-data', [AppearanceController::class, 'loadJsonDataAbout']);
                    Route::post('/update', [AppearanceController::class, 'updateAbout']);
                });
            });

    });
Route::middleware(['ClientLayout'])->group(function () {

    Route::post('/quote-product', [ClientController::class, 'quoteProduct']);
    Route::post('/contact', [ClientController::class, 'contact']);


    Route::get('/', [ClientController::class, 'viewHome'])->name('Client.Home');
    Route::get('/about-us', [ClientController::class, 'viewAbout'])->name('Client.About');
    Route::get('/contact', [ClientController::class, 'viewContact'])->name('Client.Contact');
    Route::get('/brands', [ClientController::class, 'viewBrands'])->name('Client.Brands');
    Route::get('/pb/{slug}', [ClientController::class, 'viewBrandProducts'])->name('Client.Brand.Products');
    Route::get('/products', [ClientController::class, 'viewProducts'])->name('Client.Products');
    Route::get('/pc/{slug}', [ClientController::class, 'viewCategoryProducts'])->name('Client.ProductCategory.Products');
    Route::get('/p/{slug}', [ClientController::class, 'ViewProductDetail'])->name('Client.Product.Detail');
    Route::get('/blogs', [ClientController::class, 'viewBlogs'])->name('Client.Blogs');
    Route::get('/blogs/{slug}', [ClientController::class, 'viewBlogCategories'])->name('Client.BlogCategory.Posts');
    Route::get('/blog/{slug}', [ClientController::class, 'viewBlogPostDetail'])->name('Client.BlogPost.Detail');

});



