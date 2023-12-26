<?php

namespace App\Http\Controllers\Portal\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class FileUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 's3');

            Storage::disk('s3')->setVisibility($filePath, 'public');

            return back()
                ->with('success','File uploaded successfully.')
                ->with('file', Storage::disk('s3')->url($filePath));
        }
    }
}
