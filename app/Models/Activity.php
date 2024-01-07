<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'school_id',
        'teacher_id',
        'name',
        'class',
        'activity_date',
        'bg_image'
    ];

    protected $casts = [
        'activity_date' => 'date'
    ];

    public function school() : BelongsTo {
        return $this->belongsTo(School::class);
    }

    public function teacher() : BelongsTo {
        return $this->belongsTo(Teacher::class);
    }

    public function students() : BelongsToMany {
        return $this->belongsToMany(Student::class)->withPivot('post_title');
    }

    protected function searchColumns() {
        return ['id', 'name', 'class'];
    }
}
