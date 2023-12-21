<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OderController;
use App\Http\Controllers\OderDetailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('images/{filename}', [ImageController::class, 'getImage'])->name('images.get');
Route::get('images/products/{filename}', [ImageController::class, 'getImageProduct'])->name('images.get');
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::prefix('user')->group(function () {
    Route::post('/create', [UserController::class, 'createUser']);
    Route::put('/update-password/{user}', [UserController::class, 'updatePassword']);
    Route::post('/update-avatar/{id}', [UserController::class, 'updateAvatar']);
});

Route::post('/products/{product}/update', [ProductController::class, 'updateProductInfo']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/ramdom', [ProductController::class, 'getProductRamdom']);
Route::get('/products-page', [ProductController::class, 'getProductPage']);


Route::resource('products', ProductController::class);
Route::resource('categorys', CategoryController::class);
Route::resource('oder', OderController::class);
Route::resource('users', UserController::class);
Route::resource('oderdetail', OderDetailController::class);
Route::resource('comment', CommentController::class);
Route::resource('feedback', FeedbackController::class);
Route::resource('notification', NotificationController::class);
