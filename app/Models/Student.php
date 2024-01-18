<?php

namespace App\Models;

use App\Models\Scopes\StudentRoleScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends User {

    protected $table = 'users';


    public function profile() : HasOne {
        return $this->hasOne(StudentProfile::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StudentRoleScope);

        static::creating(function ($query) {
            $query->role = 'student';
        });
    }

    protected function searchColumns() {
        return ['id', 'name', 'email', 'phone_number', 'profile' => ['parent_name', 'parent_email', 'level', 'class']];
    }
}
