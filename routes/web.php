<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;



Route::get('/login', [AuthController::class, 'loginPage'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/registration', [AuthController::class, 'registerPage'])->name('register.page');
Route::post('/registration', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::get('/', [PostController::class, 'all'])->name('posts.all');
});
