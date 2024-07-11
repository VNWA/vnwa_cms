<?php

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
                Route::prefix('categories')->group(function(){
                    Route::get('/', [CategoryBlogController::class, 'index'])->name('Blog.Categories');
                    Route::post('/update-tree', [CategoryBlogController::class, 'updateTree']);

                });
            });
    });
