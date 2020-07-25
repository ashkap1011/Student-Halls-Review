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

Route::get('/add/new-review', 'ReviewsController@writeReview');
Route::post('/post_review', 'ReviewsController@createNewReview');

Route::get('/{uni_name}/add/new-uni-dorm-review', 'ReviewsController@newUniOrDormReviewPage');
Route::post('/post_review_for_new_uni_or_dorm', 'ReviewsController@createReviewForNewUniOrDorm');

Route::get('/dormsForUni/{uni_name}','ReviewsController@dormsOnUniSelection');
Route::get('/dormNameToId/{dorm_name}','ReviewsController@dormNameToId');


Route::get('/admin_panel', 'AdminController@adminPage');
Route::get('/posted_reviews','AdminController@reviews');
Route::get('/posted_reviews_with_new_dorm','AdminController@reviewsWithNewDorm');
Route::get('/posted_reviews_with_new_uni','AdminController@reviewsWithNewUni');

//Route::get('/home', 'HomeController@index')->name('home');
//also changed use (up) to page instead of home

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
