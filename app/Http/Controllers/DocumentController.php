<?php

namespace App\Http\Controllers;

use Auth;
use File;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Storage;

class DocumentController extends Controller
{
    public function AuthLogin() {
        if(Session::get('login_normal')) {
         $admin_id = Auth::id();
         if ($admin_id) {
             return Redirect::to("dashboard");
     } else { 
         return Redirect::to("admin")->send();
     }
        }
     }
    public function upload_file(){
        $filename = 'Đánh thức';
        $filePath = public_path('uploads/document/quangcao79.docx');
        $fileData = File::get($filePath);
        Storage::cloud()->put($filename,$fileData);
        return 'File Uploaded';
    }
    public function upload_image(){
        $filename = 'logo';
        $filePath = public_path('uploads/post/bai-7-h271.jpg');
        $fileData = File::get($filePath);
        Storage::cloud()->put($filename,$fileData);
        return 'Image Uploaded';
    }

    public function upload_video(){
        $filename = 'video';
        $filePath = public_path('uploads/vieo/bai-7-h271.jpg');
        $fileData = File::get($filePath);
        Storage::cloud()->put($filename,$fileData);
        return 'Video Uploaded';
    }

    public function download_document(){
        $filename = 'video';
        $dir = '/';
        $recursive = false;
        $contents = collect(Storage::cloud()->listContents($dir,$recursive));
        $file = $contents
        ->where('type','=','file')
        ->where('filename','=',pathinfo($filename,PATHINFO_FILENAME))
        ->where('extension','=',pathinfo($filename,PATHINFO_EXTENSION))
        ->first();

        $rawData = Storage::cloud()->get($file['path']);
        return response($rawData,200)
        ->header('Content-Type',$file['mimetype'])
        ->header('Content-Disposition',$file['mimetype']);
    }

    public function read_document(){
        $fileInfo = collect(Storage::cloud()->listContents('/',false))
        ->where('type','file')
        ->where('name','test.txt')
        ->first();

        $contents = Storage::cloud()->get($fileInfo['path']);
        dd($contents);
    }
    public function delete_document(){
        $fileInfo = collect(Storage::cloud()->listContents('/',false))
        ->where('type','file')
        ->where('name','docuemnt.txt')
        ->first();

        Storage::cloud()->delete($fileInfo['path']);
        dd('Deleted');
    }

    public function list_document(){
        $dir = '/';
        $recursive = false;
        $contents = collect(Storage::cloud()->listContents($dir,$recursive))
        ->where('type','!=','dir');
        return $contents;
    }



    public function create_document(){
        Storage::disk()->put('test.txt','Hello word');
        dd('created');
    }

    public function create_folder(){
        Storage::cloud()->makeDirectory('Storage 1');
        dd('created folder');
    }

    public function rename_folder(){
        $folderinfo = collect(Storage::cloud()->listContents('/',false))
        ->where('type','dir')
        ->where('name','Storage 1')
        ->first();
        
        Storage::disk()->move($folderinfo['path'],'new');
        dd('rename folder');
    }

    public function delete_folder(){
        $folderinfo = collect(Storage::cloud()->listContents('/',false))
        ->where('type','dir')
        ->where('name','storage1')
        ->first();
        
        Storage::cloud()->delete($folderinfo['path']);
        dd('delete folder');
    }

    public function read_data(){
        $this->AuthLogin();
        $dir = '/';
        $recursive = false;
        $contents = collect(Storage::cloud()->listContents($dir,$recursive))
        ->where('type','!=','dir');
        return view('admin.document.read')->with(compact('contents'));
    }
}
