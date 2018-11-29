<?php

namespace Vanderb\Storagemanager\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Vanderb\Storagemanager\Contracts\StoragemanagerContract;
use Exception;

class StoragemanagerController extends Controller {

    public function index()
    {
        return view('storagemanager::index');
    }

    public function getByPath(Request $request, StoragemanagerContract $storagemanager) {    
        return $storagemanager->getFiles($request->get('directory'));
    }

}
