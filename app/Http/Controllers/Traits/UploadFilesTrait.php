<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadFilesTrait
{
    public function upload(Request $request){
        //Allowed Paths
        $allowedPaths = $this->allowedPaths();
        $paths = implode(',', array_keys($allowedPaths));

        $fileCustomRules = $allowedPaths[$request->input('path')] ?? [];

        //Request Rules
        $rules = [
            'path' => 'required|in:'.$paths,
            'file' => ['required', 'file', 'max:8192', ...$fileCustomRules],
        ];

        $request->validate($rules);

        $path = $request->file('file')->store($request->path.'/'.date('Y-m'), 'public');

        return response()->json(['path' => $path, 'pathUrl' => asset('storage/'.$path)]);
    }

    protected function allowedPaths() {
        return [];
    }
}
