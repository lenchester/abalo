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

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');

Route::get('/articles/', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles');
Route::get('/learnjs', [\App\Http\Controllers\ArticleController::class, 'learn_js']);
Route::get('/jsonread',[\App\Http\Controllers\ArticleController::class, 'json_reader']);
Route::get('/newarticle', [\App\Http\Controllers\ArticleController::class, 'new_article'])->name('newarticle');
Route::post('/newarticle', [\App\Http\Controllers\ArticleController::class, 'insert_article']);

