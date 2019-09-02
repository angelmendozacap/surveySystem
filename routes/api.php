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

Route::apiResource('/surveys', 'SurveysController');

Route::get('/surveys/{survey}/questions', 'QuestionsController@index');
Route::post('/surveys/{survey}/questions', 'QuestionsController@store');
Route::patch('/questions/{question}', 'QuestionsController@update');
Route::delete('/questions/{question}', 'QuestionsController@destroy');