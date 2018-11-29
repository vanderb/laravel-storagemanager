<?php

namespace Vanderb\Storagemanager\Contracts;

interface StoragemanagerContract {

    public function getFiles($directory);
    public function inIgnoreList($file);
    public function getDirectoryFileCount($directory);

    public function filterDisabled($directories);
    public function processFile($dir);
    public function processDirectory($dir);


}
