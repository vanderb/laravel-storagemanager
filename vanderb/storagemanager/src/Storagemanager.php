<?php

namespace Vanderb\Storagemanager;
use Vanderb\Storagemanager\Contracts\StoragemanagerContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

use Exception;

class Storagemanager implements StoragemanagerContract {

    public function __construct() {
        $this->disk = Storage::disk('storagemanager');
    }

    /**
     * Get files in given path
     *
     * @param [string] $path
     * @return array
     */
    public function getFiles($directory)
    {
        try{
            //Grab files
            $files = $this->disk->files($directory);
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
            $directories = $this->disk->directories($directory);
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

    public function processFile($file){
        return [
            'name' => File::name($this->disk->path($file)),
            'filetype' => File::extension($this->disk->path($file)),
            'filename' => File::basename($this->disk->path($file)),
            'size' => File::size($this->disk->path($file)),
            'mime' => File::mimeType($this->disk->path($file)),
            'url' => $this->disk->url($file),
            // 'dimensions' => $this->getPhotoDimensions($this->disk->path($file)),
            'last_modified' => Carbon::createFromTimestamp(File::lastModified($this->disk->path($file)))->toDateTimeString(),
            'path' => $file,
        ];
    }
    
    public function processDirectory($dir){
        return [
            'name' => File::basename($this->disk->path($dir)),
            'path' => $dir,
            'file_count' => $this->getDirectoryFileCount($dir),
            'last_modified' => Carbon::createFromTimestamp(File::lastModified($this->disk->path($dir)))->toDateTimeString(),
        ];
    }

}
