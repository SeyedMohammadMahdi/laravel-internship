<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductImageUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UplodTest extends Controller
{

    public function upload(ProductImageUploadRequest $request){
//        $request->validate([
//            'file' => 'required|file|mimetypes:text/plain, text/plain; charset=utf-8|max:2048'
//        ]);

//        $file = $request->file('file');
        $file = $request->imageUploadDTO->file;
//        dd($file->getMimeType());
        $fileName = uniqid() . '_' . hash_file('sha256', $file->getRealPath()) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads', $fileName, 'public');
        if(is_string($path)){
            return response()->json(Storage::disk('public')->url($path));
        }
        return response()->json(status: 400);
    }
}
