<?php

Route::group([
        'middleware'=>['web','auth'],
        'namespace'=>'Vanderb\Storagemanager\Controllers',
        'prefix'=>'storagemanager','as'=>'storagemanager::'
    ], 
    function(){
        Route::group(['prefix'=>'api', 'as' => 'api'], function() {
            Route::get('path/get', 'StoragemanagerController@getByPath');
        });

        Route::get('/', 'StoragemanagerController@index');
        Route::get('/{any}', 'StoragemanagerController@index')->where('any', '.*');
    }
);
