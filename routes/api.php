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

/**
 * V1 Routes
 */
Route::group(['namespace' => 'V1'], function () {

    /**
     * Coupon Routes
     */
    Route::group(['prefix' => 'gigs'], function () {
        Route::get('', 'GigController@index');
        Route::post('', 'GigController@store');
        Route::get('{gig}', 'GigController@get');
        Route::get('filter/{filter}', 'GigController@filter');
        Route::patch('{gig}', 'GigController@update');
        Route::delete('{gig}', 'GigController@destroy');
    });
  /**
     * Tags Routes
     */
    Route::group(['prefix' => 'tags'], function () {
        Route::get('', 'TagController@index');
        Route::post('', 'TagController@store');
        Route::get('{gig}', 'TagController@get');
        Route::patch('{gig}', 'TagController@update');
        Route::delete('{gig}', 'TagController@destroy');
    });


    Route::group(['prefix' => 'countries'], function () {
        Route::get('', 'CountryController@index');
    });

});


Route::fallback(function (){
    return response()->json([
        'message' => 'Resource not found. If error persists, contact Administrator.'
    ], 404);
});