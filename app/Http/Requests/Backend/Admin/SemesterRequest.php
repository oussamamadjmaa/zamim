<?php

namespace App\Http\Requests\Backend\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SemesterRequest extends FormRequest
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
        return [
            'name'  => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'date_format:Y-m-d', 'unique:semesters,start_date,'.$this->route('semester')?->id ],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after:start_date', 'unique:semesters,end_date,'.$this->route('semester')?->id ],
        ];
    }
}
