<?php

namespace App\Models;

use App\Models\Scopes\TeacherRoleScope;

class Teacher extends User {

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TeacherRoleScope);

        static::creating(function ($query) {
            $query->role = 'teacher';
        });
    }
}
