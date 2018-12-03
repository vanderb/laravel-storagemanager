<?php

//Media manager routes
Route::get('get-files', 'ApiMediaController@index')->name('get-files');
Route::post('delete-files', 'ApiMediaController@deleteFiles')->name('delete-files');
Route::post('upload-files', 'ApiMediaController@uploadFiles')->name('upload-files');