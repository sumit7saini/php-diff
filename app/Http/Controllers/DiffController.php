<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Libraries\DiffLib\Differ;
// use App\Libraries\DiffLib\DiffHelper;
// use App\Libraries\DiffLib\Factory\RendererFactory;
// use App\Libraries\DiffLib\Renderer\RendererConstant;

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

        Storage::makeDirectory('diff/'.$request->session()->getId().'/v1');
        Storage::makeDirectory('diff/'.$request->session()->getId().'/v2');

        if($request->hasfile('filesv2'))
            $request->session()->put('files', 'abc');

        $session_id = $request->session()->getId();

        foreach($request->file('filesv1') as $file) {
            $file->move(storage_path('app/diff').'/'.$session_id.'/v1',$file->getClientOriginalName());
        }

        foreach($request->file('filesv2') as $file) {
            $file->move(storage_path('app/diff').'/'.$session_id.'/v2',$file->getClientOriginalName());
        }

        return redirect('/diff');
    }


    public function show(Request $request){

        $session_id = $request->session()->getId();
        $path = storage_path('app/diff').'/'.$session_id;
        $filesv1 = scandir($path.'/v1');
        $filesv2 = scandir($path.'/v2');
        $common=array_intersect($filesv1,$filesv2);
        $onlyinv1=array_diff($filesv1, $common);
        $onlyinv2=array_diff($filesv2, $common);
        $files['common']=$common;
        $files['onlyinv1']=$onlyinv1;
        $files['onlyinv2']=$onlyinv2;
        return view('diff', ['data' => $files]);

    }

    public function diff(Request $request, $name){
        $session_id = $request->session()->getId();
        $path = storage_path('app/diff').'/'.$session_id;
        $oldFile = $path . '/v1/' . $name;
        $newFile = $path . '/v2/' . $name;

        $diff = Diff::toTable(Diff::compareFiles($oldFile, $newFile));
        return view('difffile', ['data' => $diff]);

        // renderer class name:
//     Text renderers: Context, JsonText, Unified
//     HTML renderers: Combined, Inline, JsonHtml, SideBySide
    $rendererName = 'SideBySide';

// the Diff class options
    $differOptions = [
    // show how many neighbor lines
    // Differ::CONTEXT_ALL can be used to show the whole file
        'context' => 3,
    // ignore case difference
        'ignoreCase' => false,
    // ignore whitespace difference
        'ignoreWhitespace' => false,
    ];

// the renderer class options
    $rendererOptions = [
    // how detailed the rendered HTML in-line diff is? (none, line, word, char)
        'detailLevel' => 'line',
    // renderer language: eng, cht, chs, jpn, ...
    // or an array which has the same keys with a language file
        'language' => 'eng',
    // show line numbers in HTML renderers
        'lineNumbers' => true,
    // show a separator between different diff hunks in HTML renderers
        'separateBlock' => true,
    // show the (table) header
        'showHeader' => true,
    // the frontend HTML could use CSS "white-space: pre;" to visualize consecutive whitespaces
    // but if you want to visualize them in the backend with "&nbsp;", you can set this to true
        'spacesToNbsp' => false,
    // HTML renderer tab width (negative = do not convert into spaces)
        'tabSize' => 4,
    // this option is currently only for the Combined renderer.
    // it determines whether a replace-type block should be merged or not
    // depending on the content changed ratio, which values between 0 and 1.
        'mergeThreshold' => 0.8,
    // this option is currently only for the Unified and the Context renderers.
    // RendererConstant::CLI_COLOR_AUTO = colorize the output if possible (default)
    // RendererConstant::CLI_COLOR_ENABLE = force to colorize the output
    // RendererConstant::CLI_COLOR_DISABLE = force not to colorize the output
        'cliColorization' => RendererConstant::CLI_COLOR_AUTO,
    // this option is currently only for the Json renderer.
    // internally, ops (tags) are all int type but this is not good for human reading.
    // set this to "true" to convert them into string form before outputting.
        'outputTagAsString' => false,
    // this option is currently only for the Json renderer.
    // it controls how the output JSON is formatted.
    // see available options on https://www.php.net/manual/en/function.json-encode.php
        'jsonEncodeFlags' => \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE,
    // this option is currently effective when the "detailLevel" is "word"
    // characters listed in this array can be used to make diff segments into a whole
    // for example, making "<del>good</del>-<del>looking</del>" into "<del>good-looking</del>"
    // this should bring better readability but set this to empty array if you do not want it
        'wordGlues' => [' ', '-'],
    // change this value to a string as the returned diff if the two input strings are identical
        'resultForIdenticals' => null,
    // extra HTML classes added to the DOM of the diff container
        'wrapperClasses' => ['diff-wrapper'],
    ];

// one-line simply compare two files
    $result = DiffHelper::calculateFiles($oldFile, $newFile, $rendererName, $differOptions, $rendererOptions);

    return view('difffile', ['data' => $result]);
    }
}
