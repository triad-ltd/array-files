<?php
namespace TriadLtd\ArrayFiles\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArrayFilesController extends Controller
{
    public function index(Request $request)
    {
        return "array files by triadltd (forked from halimtuhu)";
    }

    public function upload(Request $request)
    {
        // dd($request->file('file')->getClientOriginalName());
        $file = Storage::putFileAs('/', $request->file('file'), $request->file('file')->getClientOriginalName());


        $url = env('APP_URL');
        $url = str_replace($url, '', Storage::url($file));

        $data = [
            'name' => $file,
            'url' => $url,
        ];

        return $data;
    }

    public function delete($file)
    {
        Storage::delete($file);

        return "success";
    }
}
