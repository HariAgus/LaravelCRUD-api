<?php


use Illuminate\Http\Request;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/user', function (Request $request) {
//     return $request::user();
//  })->middleware('auth:api');

Route::any('tambah', "ApiController@addData");
Route::any('tampil', "ApiController@getData");
Route::any('search', "ApiController@searchData");
Route::any('delete', "ApiController@deleteData");
Route::any('edit', "ApiController@editData");
