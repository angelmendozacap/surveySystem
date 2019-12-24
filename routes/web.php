<?php

Auth::routes(['register' => false]);

Route::get('{any}', 'AppController@index')
    ->middleware('auth')
    ->where('any', '.*');
