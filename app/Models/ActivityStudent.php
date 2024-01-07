<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityStudent extends Model
{
    use HasFactory;

    protected $fillable = ['post_title'];

    public $timestamps = false;

    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
