<?php

namespace App\Http\Requests\Backend\School;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $emailRule = app()->isLocal() ? 'email:filter' : 'email:rfc,dns';
        $studentId = $this->route('student')?->id;

        return [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', $emailRule, 'max:255', 'unique:users,email,'.$studentId],
            'phone'                 => ['required', 'regex:/[0-9]/', 'not_regex:/[A-z]/', 'between:8,30',],
            'mobile'                => ['required', 'regex:/[0-9]/', 'not_regex:/[A-z]/', 'between:8,30',],
            'profile'               => ['required', 'array'],
            'profile.parent_name'  => ['required', 'string', 'max:255'],
            'profile.level'        => ['required', 'string', 'in:primary,middle,secondary'],
            'profile.class'  => ['required', 'string', 'max:20'],
            'profile.division'  => ['required', 'string', 'max:1'],
            // 'password'              => [$this->isMethod('PUT') ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
