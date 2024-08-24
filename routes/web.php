<?php

use App\Http\Controllers\AppearanceController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\BlogTagController;
use App\Http\Controllers\Inertia\ApiTokenController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\UrlController;
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


Route::get('vnwa/', function () {
    return Inertia::render('Admin/Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('vnwa')
    ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {
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
            });

    });


Route::get("/", function () {
    return Inertia::render('Customer/Home');
});
