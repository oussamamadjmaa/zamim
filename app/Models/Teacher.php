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
            $query->password = $query->password ?: bcrypt(\Str::random(9));
        });

        static::updating(function ($query) {
            $query->deleted_at = null;
        });
    }
}
