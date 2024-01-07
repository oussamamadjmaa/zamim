<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait AvatarAttribute{
    public function avatar() : Attribute {
        return Attribute::make(
            get: fn($avatar) => $avatar ?: 'https://ui-avatars.com/api/?name='. $this->name,
        );
    }
}
