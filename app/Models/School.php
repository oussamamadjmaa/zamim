<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\AvatarAttribute;
use App\Models\Traits\HasSubscription;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Shetabit\Visitor\Traits\Visitor;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class School extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasSubscription, AvatarAttribute, Visitor, CanResetPasswordTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'level',
        'mod_name',
        'email',
        'country',
        'city',
        'accreditation_number',
        'id_number',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function students() : HasMany {
        return $this->hasMany(Student::class);
    }

    public function teachers() : HasMany {
        return $this->hasMany(Teacher::class);
    }

    public function radios() : HasMany {
        return $this->hasMany(Radio::class);
    }

    public function activities() : HasMany {
        return $this->hasMany(Activity::class);
    }

    public function articles() : MorphMany {
        return $this->morphMany(Article::class, 'author');
    }

    /////////////////////////////////////////////////
     public function getSchoolIdAttribute() : int {
        return $this->id;
    }

    public function getSchoolAttribute() : self {
        return $this;
    }

    public function school() : self {
        return $this;
    }
    /////////////////////////////////////////////////
}
