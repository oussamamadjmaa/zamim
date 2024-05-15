<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioStudent extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function radio() {
        return $this->belongsTo(Radio::class);
    }

    public function article() {
        return $this->belongsTo(Article::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
