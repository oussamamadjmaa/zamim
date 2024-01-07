<?php

namespace App\Http\Requests\Backend\School;

use App\Rules\isSchoolStudent;
use App\Rules\isSchoolTeacher;
use App\Rules\ValidateFileRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityRequest extends FormRequest
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
        $activityId = $this->route('activity')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'bg_image' => ['required', new ValidateFileRule('activity-bgs')],
            'class'  => ['required', 'string', 'max:20'],
            'activity_date' => ['required', 'date', 'date_format:Y-m-d', Rule::unique('activities')->where(function ($query) use ($request, $activityId) {
                return $query->where('activity_date', $request->input('activity_date'))
                             ->where('school_id', auth()->user()->school_id)
                             ->where('id', '!=', $activityId);})  ],
            'teacher_id' => ['required', 'integer', new isSchoolTeacher(auth()->user()->school_id)],
            'students' => ['required', 'array'],
            'students.*.student_id' => ['required', 'integer', new isSchoolStudent(auth()->user()->school_id)],
            'students.*.post_title' => ['nullable', 'string', 'max:255']
        ];
    }
}
