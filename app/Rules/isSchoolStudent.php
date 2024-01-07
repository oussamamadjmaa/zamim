<?php

namespace App\Rules;

use App\Models\Student;
use Illuminate\Contracts\Validation\Rule;

class isSchoolStudent implements Rule
{
    protected $schoolId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($schoolId)
    {
        $this->schoolId = $schoolId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Student::whereSchoolId($this->schoolId)->whereId($value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Ops!');
    }
}
