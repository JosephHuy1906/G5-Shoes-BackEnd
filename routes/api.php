<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillDetailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::post('/auth/register', [UserController::class, 'createUser']);
Route::get('/products/search', [ProductController::class, 'search']);

Route::resource('products', ProductController::class);
Route::resource('categorys', CategoryController::class);
Route::resource('bill', BillController::class);
Route::resource('billdetail', BillDetailController::class);
Route::resource('comment', CommentController::class);
Route::resource('feedback', FeedbackController::class);
Route::resource('notification', NotificationController::class);
