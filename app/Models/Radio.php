<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\DB;
use Shetabit\Visitor\Traits\Visitable;

class Radio extends Model
{
    use HasFactory, Visitable;

    protected $fillable = [
        'semester_id',
        'level',
        'subject',
        'attachment',
        'week_number',
        'radio_date'
    ];

    protected $casts = [
        'radio_date' => 'date:Y-m-d'
    ];

    public function semester() : BelongsTo {
        return $this->belongsTo(Semester::class);
    }

    public function students() : BelongsToMany {
        return $this->belongsToMany(Student::class, RadioStudent::class)->withPivot(['article_id', 'rating']);
    }

    public function teachers() : BelongsToMany {
        return $this->belongsToMany(Teacher::class, RadioTeacher::class)->withPivot(['rating']);
    }

    public function schools() : BelongsToMany {
        return $this->belongsToMany(School::class, 'school_radio');
    }

    public function articles() : HasMany {
        return $this->hasMany(Article::class);
    }

    public function scopeWeekly($q) {
        return $q->select('semester_id', 'level', 'week_number', DB::raw('MIN(radio_date) as start_date'), DB::raw('MAX(radio_date) as end_date'))
                    ->groupBy('semester_id', 'level', 'week_number');
    }
}
