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
Route::get('/ajax1', [\App\Http\Controllers\ArticleController::class, 'simpleAjaxRequest']);
Route::get('/ajax2', [\App\Http\Controllers\ArticleController::class, 'periodicAjaxRequest']);


Route::get('/articlesAPI', [\App\Http\Controllers\ArticleController::class, 'ausgabe']);
Route::get('/newarticleAPI', [\App\Http\Controllers\ArticleController::class,'new_articleAPI']);

Route::get('/learnvue', function (){ return view('learnvue');});
Route::prefix('learnvue')->group(function (){
    Route::get('/4-vue1-helloworld.html', function (){
        return view('4-vue1-helloworld');
    });
});

///////////////////////NEWSITE:
Route::get('/newsite', [\App\Http\Controllers\ArticleController::class, 'ausgabeNewsite']);


Route::get('/maintenance', [\App\Http\Controllers\ArticleController::class, 'maintenanceMode']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
