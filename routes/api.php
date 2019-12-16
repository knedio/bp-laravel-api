<?php

use Illuminate\Http\Request;

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

// global prefix version
$version = 'v1';

// 
Route::group([
    'middleware'    => ['json.response'],
    'prefix'        => $version,
    'namespace'     => 'Api',
], function () {

    // Authentication
    Route::group([
        'prefix' => 'auth',
    ], function(){
        // public routes
        Route::post('login', 'AuthController@login');
        Route::post('store', 'AuthController@store');
        Route::patch('reset-password', 'AuthController@resetPassword');

        // private routes
        Route::group([
            'middleware' => [
                'auth:api',
            ],
        ], function(){
            Route::get('logout', 'AuthController@logout');
        });
    });

    // User
    Route::group([
        'prefix' => 'user',
    ], function(){

        // private routes
        Route::group([
            'middleware' => [
                'auth:api',
            ],
        ], function(){
            Route::patch('update/{id}', 'UserController@update');
            Route::patch('reset-password/{id}', 'UserController@resetPasswordDefault');
            Route::patch('change-password', 'UserController@changePassword');
            Route::delete('destroy/{id}', 'UserController@destroy');
            Route::get('get/{id}', 'UserController@get');
            Route::get('get-all', 'UserController@getAll');
        });
    });
    

});
