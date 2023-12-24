<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_name',
        'level',
        'class',
        'division'
    ];

    public function student() {
        return $this->belongsTo(User::class);
    }
}
