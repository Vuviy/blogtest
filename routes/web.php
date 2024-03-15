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

Route::post('addComment', [\App\Http\Controllers\Home::class, 'addComment'])->name('addComment');
