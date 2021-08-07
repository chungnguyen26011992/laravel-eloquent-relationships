<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;

Route::get('/', [UserController::class, 'index']);
Route::get('/users/{id}/phone', [UserController::class, 'getPhoneOfUser']);
Route::get('/users/{id}/posts', [UserController::class, 'getPostsOfUser']);
Route::get('/phones/{id}/user', [PhoneController::class, 'getUserByPhone']);
Route::get('/posts/{id}/user', [PostController::class, 'getUserByPost']);
Route::get('/posts/{id}/image', [PostController::class, 'getImageOfPost']);
Route::get('/categories/{id}/products', [CategoryController::class, 'getProductsByCategory']);
Route::get('/products/{id}/categories', [ProductController::class, 'getCategoriesByProduct']);
Route::get('/images/{id}/parent-model', [ImageController::class, 'getParentModelOfImage']);
