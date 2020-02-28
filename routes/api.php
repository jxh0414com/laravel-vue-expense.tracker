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

Route::prefix('auth')->group(function () {
   Route::post('/login', 'AuthController@login');
   Route::get('/loadUser', 'AuthController@loadUser');
   Route::get('/logout', 'AuthController@logout');
});

Route::prefix('user')->group(function () {
    Route::post('/register', 'UserController@register');
});

Route::prefix('transactions')->group(function () {
    Route::post('/', 'TransactionController@createTransaction');
    Route::get('/', 'TransactionController@getTransactions');
    Route::post('/delete', 'TransactionController@deleteTransaction');
    Route::post('/getTotal', 'TransactionController@getTotal');
});



