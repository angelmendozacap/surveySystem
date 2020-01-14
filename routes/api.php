<?php

Route::middleware('auth:api')->group(function () {

    Route::get('/auth-user', 'AuthUserController@show');

    Route::apiResource('/surveys', 'SurveysController');
    Route::patch('/surveys/{survey}/change-status', 'SurveysController@changeStatus');

    Route::get('/surveys/{survey}/questions', 'QuestionsController@index');
    Route::post('/surveys/{survey}/questions', 'QuestionsController@store');
    Route::patch('/questions/{question}', 'QuestionsController@update');
    Route::delete('/questions/{question}', 'QuestionsController@destroy');

    Route::get('/input-types', 'InputTypeController@index');
    Route::post('/input-types', 'InputTypeController@store');
    Route::delete('/input-types/{inputType}', 'InputTypeController@destroy');

    Route::get('/option-groups', 'OptionGroupsController@index');
    Route::post('/option-groups', 'OptionGroupsController@store');
    Route::get('/option-groups/{group}', 'OptionGroupsController@show');
    Route::patch('/option-groups/{group}', 'OptionGroupsController@update');
    Route::delete('/option-groups/{group}', 'OptionGroupsController@destroy');

    Route::get('/questions/{question}/answers', 'AnswersController@index');
    Route::post('/questions/{question}/answers', 'AnswersController@store');
    Route::patch('/answers/{answer}', 'AnswersController@update');
    Route::delete('/answers/{answer}', 'AnswersController@destroy');

    Route::get('/surveys-to-answer', 'SurveyUserController@index');
    Route::get('/surveys-to-answer/{survey}', 'SurveyUserController@show');
    Route::post('/surveys-to-answer/{survey}', 'SurveyUserController@store');

    Route::get('/surveys-answered', 'SurveysTakenController@index');
});
