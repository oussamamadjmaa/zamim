<?php

namespace App\Http\Requests\Backend\School;

use App\Rules\isSchoolStudent;
use App\Rules\isSchoolTeacher;
use App\Rules\ValidateFileRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Validator;

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
            'teacher_id' => ['required', 'integer', new isSchoolTeacher(auth()->user()->school_id)],
            'students' => ['required', 'array'],
            'students.*.student_id' => ['required', 'integer', new isSchoolStudent(auth()->user()->school_id)],
            'students.*.article_id' => ['nullable', 'integer', 'exists:articles,id'],
            'students.*.article' => [
                'required_without:students.*.article_id',
                function ($attribute, $value, $fail) use ($request) {
                    // Get the index of the current student being validated
                    $index = explode('.', $attribute)[1];
                    // Check if article_id is null or not provided for the current student
                    $articleId = $request->input("students.$index.article_id");

                    if ($articleId === null || empty($articleId)) {
                        // If article_id is not provided, then validate article array
                        $article = $request->input("students.$index.article");
                        $validator = Validator::make($article, [
                            'title' => ['required', 'string', 'max:255'],
                            'is_public' => ['required','boolean'],
                            'attachment' => ['required', new ValidateFileRule('article-attachments')],
                        ]);

                        if ($validator->fails()) {
                            $fail('يجب ادخال قيم المقال, العنوان ومشاركة المقال, ومرفق المقال.');
                        }
                    }
                }
            ],

        ];
    }

    public function messages() {
        return [
            'teacher_id.required' => "رائد الصف مطلوب",
            'students.*.article.required_array_keys' => 'يجب ادخال قيم المقال, العنوان ومشاركة المقال, ومرفق المقال',
            'students.*.article.is_public.boolean' => 'يجب تحديد نعم او لا'
        ];
    }
}
