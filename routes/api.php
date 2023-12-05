<?php

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


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);

Route::resource('products', ProductController::class);
Route::resource('categorys', CategoryController::class);
Route::resource('bill', BillController::class);
Route::resource('billdetail', BillDetailController::class);
Route::resource('comment', CommentController::class);
Route::resource('feedback', FeedbackController::class);
Route::resource('notication', NotificationController::class);
