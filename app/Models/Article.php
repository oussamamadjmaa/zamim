<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'author_type',
        'radio_id',
        'title',
        'attachment',
        'is_public'
    ];

    public function author() {
        return $this->morphTo();
    }

    public function radio() {
        return $this->belongsTo(Radio::class);
    }
}
