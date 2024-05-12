<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UploadFilesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFilesController extends Controller
{
    use UploadFilesTrait;

    protected function allowedPaths()
    {
        return [
            'radio-bgs' => ['mimetypes:image/png,image/jpeg,image/webp', 'max:5120'],
            'activity-bgs' => ['mimetypes:image/png,image/jpeg,image/webp', 'max:5120'],
            'article-attachments' => ['mimes:doc,docx,pdf', 'max:5120'],
        ];
    }
}
