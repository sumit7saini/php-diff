<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Libraries\Diff;



class DiffController extends Controller
{
    //

    public function index(){
        return view('dashboard');


    }

    public function filesUploaded(Request $request){

        $time = time();

        Storage::makeDirectory('diff/'.$time.'/v1');
        Storage::makeDirectory('diff/'.$time.'/v2');

        if($request->hasfile('filesv2'))
            $request->session()->put('files', 'abc');

        $session_id = $request->session()->getId();

        foreach($request->file('filesv1') as $file) {
            $file->move(storage_path('app/diff').'/'.$session_id.'/v1',$file->getClientOriginalName());
        }

        foreach($request->file('filesv2') as $file) {
            $file->move(storage_path('app/diff').'/'.$session_id.'/v2',$file->getClientOriginalName());
        }

        return redirect('/diff/'.$time);
    }


    public function show(Request $request, $foldername){

        $path = storage_path('app/diff').'/'.$foldername;
        $filesv1 = scandir($path.'/v1');
        $filesv2 = scandir($path.'/v2');
        $common=array_intersect($filesv1,$filesv2);
        $onlyinv1=array_diff($filesv1, $common);
        $onlyinv2=array_diff($filesv2, $common);
        $files['common']=$common;
        $files['onlyinv1']=$onlyinv1;
        $files['onlyinv2']=$onlyinv2;
        $files['folder']=$foldername;
        return view('diff', ['data' => $files]);

    }

    public function diff(Request $request, $foldername, $filename){
        $path = storage_path('app/diff').'/'.$foldername;
        $oldFile = $path . '/v1/' . $filename;
        $newFile = $path . '/v2/' . $filename;

        $diff = Diff::toTable(Diff::compareFiles($oldFile, $newFile));
        return view('difffile', ['data' => $diff]);
    }
}
