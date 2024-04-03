<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioTeacher extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function radio() {
        return $this->belongsTo(Radio::class);
    }

    public function teacher() {
        return $this->belongsTo(teacher::class);
    }
}
