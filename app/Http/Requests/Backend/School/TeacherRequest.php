<?php

namespace App\Http\Requests\Backend\School;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
        $teacherId = $this->route('teacher')?->id;

        return [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['nullable', 'string', $emailRule, 'max:255', 'unique:users,email,'.$teacherId],
            'phone_number'          => ['required', 'regex:/[0-9]/', 'not_regex:/[A-z]/', 'between:8,16',],
            // 'password'              => [$this->isMethod('PUT') ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
