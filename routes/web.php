<?php

use App\Http\Controllers\PageController;
use App\Review;
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

Route::get('/add/new-review', 'ReviewsController@index');
Route::post('/post_review', 'ReviewsController@createNewReview');

Route::get('/{uni_name}/add/new-dorm-review', 'ReviewsController@newDormReviewPage');
Route::post('/post_dorm_review', 'ReviewsController@createNewDormReview');


Route::get('/add/new-uni-dorm-review','ReviewsController@newUniAndDormReviewPage');
Route::post('/post_uni_and_dorm_review','ReviewsController@createNewUniAndDormReview');


Route::get('/dormsForUni/{uni_name}','ReviewsController@dormsOnUniSelection');
Route::get('/dormNameToId/{dorm_name}','ReviewsController@dormNameToId');




//Route::get('/home', 'HomeController@index')->name('home');
//also changed use (up) to page instead of home

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
