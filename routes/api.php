<?php

use Illuminate\Http\Request;
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

Route::prefix('/campaign')->group(function() {
    Route::get('/search/popular', 'SearchController@popular');
    Route::get('/search', 'SearchController@index');
    Route::get('/all','SubmissionController@all');
    Route::get('/{id}','SubmissionController@show_campaign_detail');
    Route::middleware('auth:api')->post('/start', 'SubmissionController@store');
    Route::middleware('auth:api')->post('/close/{id}','ProfileController@Close_Submission');
    Route::middleware('auth:api')->post('/withdraw','ProfileController@submit_withdraw');
});

Route::prefix('/donation')->group(function() {
    Route::post('/store', 'DonationController@Donations');
    Route::get('/done', 'DonationController@information_donation');
});

Route::prefix('/auth')->group(function() {
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@login');
    Route::middleware('auth:api')->get('/current', 'UserController@currentUser');
});

Route::prefix('/profile')->group(function() {
    Route::middleware('auth:api')->get('/info/{id}','ProfileController@get_history_submision_donation');
    Route::middleware('auth:api')->post('/update', 'ProfileController@update_profile');
    Route::middleware('auth:api')->post('/password/change', 'ProfileController@update_password');
});

Route::prefix('/dashboard')->group(function() {
    Route::middleware('auth:api')->get('/all', 'DashboardController@index');
    Route::middleware('auth:api')->put('/submission/close', 'DashboardController@close_submission');
    Route::middleware('auth:api')->put('/withdraw/accept', 'DashboardController@accept_withdraw');
    Route::middleware('auth:api')->put('/withdraw/decline', 'DashboardController@decline_withdraw');
    Route::middleware('auth:api')->delete('/submission/destroy', 'DashboardController@destroy_submission');
    Route::middleware('auth:api')->delete('/user/destroy', 'DashboardController@destroy_user');
});