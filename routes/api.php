<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/book-appointment', [UserController::class, 'bookYourAppointment'])->name('book-appointment');
Route::get('/get-all-catalogs', [CatalogController::class, 'getAllCatalogs'])->name('get-all-catalogs');
Route::get('/get-catalog-by-slug/{slug}', [CatalogController::class, 'getCatalogBySlug'])->name('get-catalog-by-slug');
Route::get('/get-all-blogs', [BlogController::class, 'getAllBlogs'])->name('get-all-blogs');
Route::get('/get-blog-by-slug/{slug}', [BlogController::class, 'getBlogBySlug'])->name('get-blog-by-slug');

Route::middleware(['auth:api'])->group(function(){
    Route::post('/create-catalog', [CatalogController::class, 'createCatalog'])->name('create-catalog');
    Route::post('/update-catalog/{catalog}', [CatalogController::class, 'updateCatalog'])->name('update-catalog');
    Route::delete('/delete-catalog/{catalog}', [CatalogController::class, 'deleteCatalog'])->name('delete-catalog');

    Route::post('/create-blog', [BlogController::class, 'createBlog'])->name('create-blog');
    Route::post('/update-blog/{blog}', [BlogController::class, 'updateBlog'])->name('update-blog');
    Route::delete('/delete-blog/{blog}', [BlogController::class, 'deleteBlog'])->name('delete-blog');
    
    Route::get('/get-all-appointments', [UserController::class, 'getAllAppointments'])->name('get-all-appointments');
    Route::post('/change-password/{user}', [UserController::class, 'changeUserPassword'])->name('change-password');
});
