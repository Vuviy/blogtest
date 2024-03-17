<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [\App\Http\Controllers\Home::class, 'index'])->name('home');
Route::get('/article/{id}', [\App\Http\Controllers\Home::class, 'article'])->name('article');

Route::post('addComment', [\App\Http\Controllers\Comment::class, 'addComment'])->name('addComment');

    Route::get('/login', [\App\Http\Controllers\Admin\Authenticate::class, 'loginForm'])->name('login_form');
    Route::post('/login', [\App\Http\Controllers\Admin\Authenticate::class, 'login'])->name('login');
    Route::post('/logout', [\App\Http\Controllers\Admin\Authenticate::class, 'logout'])->name('logout');

Route::prefix('/admin')->group(function (){
    Route::get('/', [\App\Http\Controllers\Admin\Admin::class, 'index'])->middleware(['auth', 'admin'])->name('admin');

    Route::resource('article', \App\Http\Controllers\Admin\Article::class)->middleware(['auth', 'admin']);

    Route::post('/deleteImage', [\App\Http\Controllers\Admin\Article::class, 'deleteImage'])->middleware(['auth', 'admin'])->name('deleteImage');
});
