<?php

Route::group(
    [
        'middleware' => ['web', 'auth'],
        'namespace' => 'Vanderb\Storagemanager\Controllers',
        'prefix' => 'storage-manager', 'as' => 'storagemanager::'
    ], 
    function() {
        // StorageManagerTestRoute
        Route::get('/', 'StorageManagerController@index')->name('storage-manager');
        Route::post('/', 'StorageManagerController@handleUpload')->name('storage-manager.upload');
    }
);