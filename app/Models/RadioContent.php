<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'attachment'
    ];

    public function school() {
        return $this->belongsTo(School::class);
    }
}
