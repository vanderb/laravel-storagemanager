<?php

/**
 * Config file for Laravel Storage Manager
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Define a storage disk to be used
    |--------------------------------------------------------------------------
    |
    | If you wish to use a certain storage disk for the manager define it here.
    | Setting this to null will load the standard local storage disk from
    | Laravel.
    |
    */
    'storage_disk' => null,
    
    /*
    |--------------------------------------------------------------------------
    | Disable certain folders
    |--------------------------------------------------------------------------
    |
    | Here you can exclude certain folders from being displayed in the storage
    | manager. By default logs/framework is excluded from display. 
    |
    */
    'disabled_folders' => [
        'app',
        'framework'
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Disable certain folders
    |--------------------------------------------------------------------------
    |
    | Here you can exclude certain folders from being displayed in the storage
    | manager. By default logs/framework is excluded from display. 
    |
    */
    'ignore_list' => [
        '.gitignore',
    ],
];
