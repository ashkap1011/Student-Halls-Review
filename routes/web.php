<?php

use App\Http\Controllers\PageController;
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

/*
Route::get('/', function () {
    return view('welcome');
});
*/


Route::get('/', 'PageController@index');

Route::get('/review', 'ReviewsController@index');

Route::post('/newreview', 'ReviewsController@create');

Route::get('/dormsForUni/{uniName}','ReviewsController@dormsOnUniSelection');
Route::get('/dormNameToId/{dormName}','ReviewsController@dormNameToId');



Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
//also changed use (up) to page instead of home

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
