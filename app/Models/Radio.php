<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Radio extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'teacher_id',
        'title',
        'class',
        'date'
    ];

    protected $casts = [
        'date' => 'date'
    ];


    public function school() : BelongsTo {
        return $this->belongsTo(School::class);
    }

    public function teacher() : BelongsTo {
        return $this->belongsTo(Teacher::class);
    }

    public function students() : BelongsToMany {
        return $this->belongsToMany(Student::class);
    }

}
