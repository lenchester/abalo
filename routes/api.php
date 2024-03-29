<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleAPIController;
use App\Http\Controllers\newarticleAPIController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
/{shoppingcartid}/{articleid}/{creatorid}
/{shoppingcartid}/{articleid}
});*/

Route::post('/newarticleAPI', [newarticleAPIController::class,'insert_article']);

Route::get('/articlesAPI', [ArticleAPIController::class, 'search']);
Route::get('/articlesAPI/availableitems', [ArticleAPIController::class, 'available_articles']);
Route::get('/articlesAPI/shoppingcartitems', [ArticleAPIController::class, 'shoppingcart_items']);
Route::post('/articlesAPI/addtocart', [ArticleAPIController::class, 'add_to_cart']);
Route::delete('/articlesAPI/removefromcart/{shoppingcartid}/{articleid}', [ArticleAPIController::class, 'remove_from_cart']);
Route::delete('/articlesAPI/emptycart/{shoppingcartid}', [ArticleAPIController::class, 'remove_all_from_cart']);


////////////////////////////////////////////////////////////////////// NEWARTIClE:
Route::get('/newsite', [ArticleAPIController::class, 'search']);
Route::get('/newsite/availableitems', [ArticleAPIController::class, 'available_articles']);
Route::get('/newsite/shoppingcartitems', [ArticleAPIController::class, 'shoppingcart_items']);
Route::post('/newsite/addtocart', [ArticleAPIController::class, 'add_to_cart']);
Route::delete('/newsite/removefromcart/{shoppingcartid}/{articleid}', [ArticleAPIController::class, 'remove_from_cart']);
Route::delete('/newsite/emptycart/{shoppingcartid}', [ArticleAPIController::class, 'remove_all_from_cart']);
Route::get('/newsite/search', [ArticleAPIController::class, 'search_offset']);
Route::get('/newsite/getsearchnumber', [ArticleAPIController::class,'number_of_search_results']);
Route::post('/islogged', [ArticleAPIController::class, 'isLogged']);
Route::get('/{id}/sold', [ArticleAPIController::class, 'sold']);
Route::post('/{id}/makeoffer', [ArticleAPIController::class, 'makeoffer']);






