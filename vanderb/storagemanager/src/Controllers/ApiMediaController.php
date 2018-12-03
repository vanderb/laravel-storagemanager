<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ApiMediaController extends Controller{
    
    protected $disk,$file_system;
    
    public function __construct() {
        $this->disk = Storage::disk($this->setDisk());
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        
        try{
            //Grab files
            $files = $this->disk->files($request->get('directory'));
            //Filter files for . files
            //dd($files);
            foreach($files as $k=>$file){
                if($this->inIgnoreList($file)){
                    unset($files[$k]);
                }
                else{
                    $files[$k] = $this->processFile($file);
                }
            }
            $files = array_values($files);
            //Grab all directories
            $directories = $this->disk->directories($request->get('directory'));
            //dd($directories);
            foreach($directories as $key=>$dir){
                $directories[$key] = $this->processDirectory($dir);
            }
            $directories = array_values($directories);
            //dd($directories);
            //Filter disabled directories
            $directories = $this->filterDisabled($directories);
            return response()->json(['success'=>true,'files'=>$files,'directories'=>$directories],200);
        } catch (Exception $ex) {
            return response()->json(['success'=>false,'message'=>$ex->getMessage().'--'.$ex->getLine()],500);
        }
        
    }
    
    public function deleteFiles(Request $request){
        try{
            //dd($request->get('deleted_files'));
            $deleted = [];
            foreach($request->get('deleted_files') as $file){
                $this->disk->delete($file);
                $deleted[] = $file;
            }
            return response()->json(['success'=>true,'deleted_files'=>$deleted],200);
        } catch (Exception $ex) {
            return response()->json(['success'=>false,'deleted_files'=>$deleted,'message'=>$ex->getMessage()],422);
        }
    }
    
    public function makeDirectory(Request $request){
        try{
            $this->disk->makeDirectory($request->get('path'));
            return response()->json(['success'=>true],200);
        } catch (Exception $ex) {
            return response()->json(['success'=>false,'message'=>$ex->getMessage()],422);
        }
    }

    public function deleteDirectory(Request $request){
        try{
            if($this->getDirectoryFileCount($request->get('path')) > 0){
                throw new Exception('Directory is not empty!');
            }
            $this->disk->deleteDirectory($request->get('path'));
            return response()->json(['success'=>true],200);
        } catch (Exception $ex) {
            return response()->json(['success'=>false,'message'=>$ex->getMessage()],422);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFiles(Request $request){
        //dd($request->all());
        try{
            if($request->hasFile('files')){
                return response()->json([
                    $this->processFile($this->handleUpload($request, 'files')),
                ],200);
            }
            throw new Exception('No file uploaded');
        } catch (Exception $ex) {
            return response()->json(['success'=>false,'message'=>$ex->getMessage().'--'.$ex->getFile()],422);
        }
    }
    
    //Service functions from here
    public function getPhotoDimensions($file_path){
        try{
            if($dimensions = getimagesize($file_path)){
                return [
                    'width' => $dimensions[0],
                    'height' => $dimensions[1]
                ];
            }
            throw new Exception('File is not an image'); 
        } catch (Exception $ex) {
            return false;
        }
    }
    
    public function filterDisabled($directories){
        foreach($directories as $k=>$dir){
            if(isset($dir['name']) && in_array($dir['name'], config('storagemanager.disabled_folders'))){
                unset($directories[$k]);
            }
            elseif(!isset($dir['name']) && in_array($dir, config('storagemanager.disabled_folders'))){
                unset($directories[$k]);
            }
        }
        return $directories;
    }
    
    public function inIgnoreList($file){
        if(starts_with($file,'.') || in_array(File::basename($file),config('storagemanager.ignore_list'))){
            return true;
        }
        return false;
    }
    
    public function getDirectoryFileCount($directory){
        $files = $this->disk->files($directory);
        //Count files
        foreach($files as $k=>$file){
            if($this->inIgnoreList($file)){
                unset($files[$k]);
            }
        }
        //Count directories
        $directories = $this->filterDisabled($this->disk->directories($directory));
        return count($files)+count($directories);
    }


    public function remove_element($array,$value) {
        return array_diff($array, (is_array($value) ? $value : array($value)));
    }
    
    public function handleUpload(Request $request, $fieldname = 'photo'){
        if(is_null($request->file($fieldname)) || !$request->file($fieldname)->isValid()){
            throw new \Exception(trans('crud.invalid_file_upload'));
        }
        
        //Get filename
        $basename = basename($request->file($fieldname)->getClientOriginalName(),'.'.$request->file($fieldname)->getClientOriginalExtension());
        //Always randomize
        $filename = uniqid().'_'.str_slug($basename).'.'.$request->file($fieldname)->getClientOriginalExtension();
        //Move file to location
        $moved = $request->file($fieldname)->storeAs($request->get('path'),$filename,$this->setDisk());
        //Return filename as string
        return $moved;
    }
    
    private function setDisk($disk = null){
        if(is_null(config('storagemanager.storage_disk')) && is_null($disk)){
            return 'local';
        }
        elseif(!is_null($disk)){
            $disk;
        }
        else{
            return config('storagemanager.storage_disk');
        }
    }
    
    private function processFile($file){
        return [
                    'name' => File::name($this->disk->path($file)),
                    'filetype' => File::extension($this->disk->path($file)),
                    'filename' => File::basename($this->disk->path($file)),
                    'size' => File::size($this->disk->path($file)),
                    'mime' => File::mimeType($this->disk->path($file)),
                    'url' => $this->disk->url($file),
                    'dimensions' => $this->getPhotoDimensions($this->disk->path($file)),
                    'last_modified' => Carbon::createFromTimestamp(File::lastModified($this->disk->path($file)))->toDateTimeString(),
                    'path' => $file,
                ];
    }
    
    private function processDirectory($dir){
        return [
                    'name' => File::basename($this->disk->path($dir)),
                    'path' => $dir,
                    'file_count' => $this->getDirectoryFileCount($dir),
                    'last_modified' => Carbon::createFromTimestamp(File::lastModified($this->disk->path($dir)))->toDateTimeString(),
                ];
    }
    
}
