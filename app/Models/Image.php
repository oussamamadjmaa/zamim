<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'path', 'order', 'file_size',
        'file_type', 'thumbnail_path', 'external_url', 'type'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
