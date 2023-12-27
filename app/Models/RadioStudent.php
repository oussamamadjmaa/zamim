<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioStudent extends Model
{
    use HasFactory;

    public function radio() {
        return $this->belongsTo(Radio::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
