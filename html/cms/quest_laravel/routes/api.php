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

// get list of tasks
Route::get('tasks/{userid}','TaskController@index');
// get specific task
Route::get('task/{id}','TaskController@show');
// create new task
Route::post('task','TaskController@store');
// update existing task
Route::put('task','TaskController@store');
// delete a task
Route::delete('task/{id}','TaskController@destroy');