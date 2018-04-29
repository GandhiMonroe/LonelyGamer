<?php

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

/*Route::group(['middleware' => 'auth:api'], function (){
    Route::post('signup', 'UserController@register');
});*/

Route::post('signup', 'UserController@register');

Route::post('login', 'UserController@signin');

Route::get('getGames', 'GameController@getAll');

Route::get('getRolesByGame', 'RoleController@getAllRolesByGame');

Route::post('newPref', 'UserController@insertPref');

Route::get('getMatches', 'MatchController@getAll');

Route::post('enterQueue', 'MatchController@enterQueue');

Route::post('exitQueue', 'MatchController@exitQueue');

Route::get('getCompList', 'MatchController@getList');

Route::get('sendRequest', 'MatchController@sendRequest');

Route::get('declineRequest', 'MatchController@declineRequest');

Route::get('getRecentGames', 'UserController@getRecentGames');