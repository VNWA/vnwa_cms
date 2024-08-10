<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\TagBlogController;
use App\Http\Controllers\UrlController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CategoryBlogController;
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

Route::get("/", function () {
    return view("wellcome");
});
Route::get('vnwa/', function () {
    return Inertia::render('Welcome', [
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
            return Inertia::render('Dashboard');
        })->name('dashboard');
        Route::prefix('media')->group(function () {
            Route::get('/', function () {
                return Inertia::render('Media');
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
                    Route::get('/', [CategoryBlogController::class, 'index'])->name('Blog.Categories');
                    Route::get('/load-new-tree-data', [CategoryBlogController::class, 'loadNewDataTree']);

                    Route::post('/update-tree', [CategoryBlogController::class, 'updateTree']);
                    Route::get('/get-detail-category/{id}', [CategoryBlogController::class, 'getDetailCategory']);
                    Route::post('/create', [CategoryBlogController::class, 'create']);
                    Route::post('/update/{id}', [CategoryBlogController::class, 'update']);
                    Route::post('/delete/{id}', [CategoryBlogController::class, 'delete']);

                });
                Route::prefix('tags')->group(function () {
                    Route::get('/load-data-table', [TagBlogController::class, 'loadDataTable']);
                    Route::get('/', function () {
                        return Inertia::render('TagBlog');
                    })->name('Blog.Tag');
                    Route::post('/create', [TagBlogController::class, 'create']);
                    Route::post('/update/{id}', [TagBlogController::class, 'update']);
                    Route::post('/delete', [TagBlogController::class, 'delete']);
                });
                Route::prefix('posts')->group(function () {
                    Route::get('/', function () {
                        return Inertia::render('Post/Show');
                    })->name('Blog.Post');
                    Route::get('/load-data-table', [BlogController::class, 'loadDataTable']);
                    Route::get('/load-data-categories-tree-and-tags', [BlogController::class, 'loadDataCategoriesTreeAndTags']);
                    Route::get('/load-data-categories-and-tags', [BlogController::class, 'loadDataCategoriesAndTags']);
                    Route::get('/create', function () {
                        return Inertia::render('Post/Create');
                    })->name('Blog.Post.Create');
                    Route::post('/create', [BlogController::class, 'create']);
                    Route::get('/edit/{id}', [BlogController::class, 'showEdit'])->name('Blog.Post.Edit');
                    Route::post('/update/{id}', [BlogController::class, 'update']);
                    Route::post('/delete', [BlogController::class, 'delete']);

                });
            });
    });
