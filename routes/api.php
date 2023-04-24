<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// all routes that require jwt verification
Route::group(['middleware' => ['jwt.verify']], function (){
    // accounts routes
    Route::group(['prefix' => 'tasks'], function() {
        Route::get('/', 'TaskController@admin');
    });
});

Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@create');
Route::post('/login', 'App\Http\Controllers\Auth\LogInController@login');

