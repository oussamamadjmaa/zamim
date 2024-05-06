<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UploadFilesTrait;
use Illuminate\Http\Request;

class UploadFilesController extends Controller
{
    use UploadFilesTrait;

    protected function allowedPaths()
    {
        return [
            'article-attachments' => ['mimes:doc,docx,pdf', 'max:5120'],
        ];
    }
}
