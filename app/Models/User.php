<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\AvatarAttribute;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Shetabit\Visitor\Traits\Visitor;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Searchable, AvatarAttribute, Visitor;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_id',
        'name',
        'email',
        'phone_number',
        'role',
        'password',
        'avatar',
        'phone_verification_code',
        'last_phone_code_at'
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
        'last_phone_code_at' => 'datetime'
    ];

    public function school() : BelongsTo {
        return $this->belongsTo(School::class);
    }

    public function phoneNumber() : Attribute {
        return Attribute::make(
            set: fn($phoneNumber) => $phoneNumber ? "+966".substr(preg_replace('/[^0-9]/', '', $phoneNumber), -9) : null,
            get: fn($phoneNumber) => $phoneNumber ? "+966".substr(preg_replace('/[^0-9]/', '', $phoneNumber), -9) : null
        );
    }

    public function routeNotificationForTwilio()
    {
        return $this->phone_number;
    }

    public function routeNotificationForMail($notification) {
        return isset($notification->customEmail) ? $notification->customEmail :  $this->email;
    }

    protected function searchColumns() {
        return ['id', 'name', 'email', 'phone_number'];
    }
}
