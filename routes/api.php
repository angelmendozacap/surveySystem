<?php

Route::middleware('auth:api')->group(function () {

    Route::get('/auth-user', 'AuthUserController@show');

    Route::apiResource('/surveys', 'SurveysController');

    Route::get('/surveys/{survey}/questions', 'QuestionsController@index');
    Route::post('/surveys/{survey}/questions', 'QuestionsController@store');
    Route::patch('/questions/{question}', 'QuestionsController@update');
    Route::delete('/questions/{question}', 'QuestionsController@destroy');

    Route::get('/option-groups', 'OptionGroupsController@index');
    Route::post('/option-groups', 'OptionGroupsController@store');
    Route::get('/option-groups/{group}', 'OptionGroupsController@show');
    Route::patch('/option-groups/{group}', 'OptionGroupsController@update');
    Route::delete('/option-groups/{group}', 'OptionGroupsController@destroy');

    Route::post('/surveys/{survey}/answers', 'AnswersController@store');
});
