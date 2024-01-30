<?php

namespace App\Http\Requests\Backend\School;

use App\Rules\isSchoolStudent;
use App\Rules\isSchoolTeacher;
use App\Rules\ValidateFileRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RadioRequest extends FormRequest
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
        $request = $this;
        $radioId = $this->route('radio')?->id;

        return [
            'class'  => ['required', 'string', 'max:20'],
            'radio_date' => ['required', 'date', 'date_format:Y-m-d', Rule::unique('radios')->where(function ($query) use ($request, $radioId) {
                return $query->where('radio_date', $request->input('radio_date'))
                             ->where('school_id', auth()->user()->school_id)
                             ->where('id', '!=', $radioId);})  ],
            'teacher_id' => ['required', 'integer', new isSchoolTeacher(auth()->user()->school_id)],
            'students' => ['required', 'array'],
            'students.*' => ['required', 'integer', new isSchoolStudent(auth()->user()->school_id)]
        ];
    }
}
