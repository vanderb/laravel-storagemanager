<?php

namespace Vanderb\Storagemanager\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class StorageManagerController extends Controller
{
    public function index()
    {
        return view('storagemanager::index');
    }

    public function handleUpload(Request $request)
    {
        $currentRoute = json_decode($request->get('currentRoute'));
        $uploadTo = $currentRoute->fullPath;

        try {

            if ($request->hasFile('file')) {
                $uploadFileName = $request->file('file')->getClientOriginalName();
                $newFilePath = $uploadTo == '/' ? $uploadTo . $uploadFileName : $uploadTo . '/' . $uploadFileName;

                if (\Storage::exists($newFilePath)) {
                    return response('File with this name already exists!', 400);
                }

                $stored = $request->file('file')->storeAs($uploadTo, $uploadFileName);

                return response('Upload success!', 200);
            }

            return response('Upload Error!', 400);

        } catch (\Exception $ex) {
            return response($ex->getMessage(), 400);
        }

    }
}
