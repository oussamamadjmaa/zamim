<?php

namespace App\Imports;

use App\Models\School;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use Str;

class StudentsImport implements OnEachRow, WithHeadingRow
{
    protected $school, $level;

    public function __construct(School $school, $level)
    {
        $this->school = $school;
        $this->level = $level;
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $row['phone_number'] = substr(preg_replace('/[^0-9]/', '', ($row['phone_number'] ?? '')), -9);

        $validator = $this->validator($row);
        if ($validator->fails()) {
            return;
        }

        $studentData = $validator->validated();

        try {
            $student = $this->updateOrCreateStudent($studentData);

            $this->studentProfile($student, $studentData);

            session()->increment('imported_students');
        } catch (\Throwable $th) {
            // dd($th);
        }
    }

    private function validator($row)
    {
        $emailRule = app()->isLocal() ? 'email:filter' : 'email:rfc,dns';
        return validator($row, [
            'name'          => ['required', 'string'],
            'email'         => ['required', 'string', $emailRule],
            'phone_number'  => ['required', 'regex:/[0-9]/', 'between:8,16'],
            'parent_name'   => ['required', 'string'],
            'parent_email'  => ['nullable', 'string'],
            'class'         => ['required', 'string'],
            'division'      => ['required', 'string'],
        ]);
    }

    private function updateOrCreateStudent($studentData)
    {
        return $this->school->students()->withTrashed()->updateOrCreate(
            ['email' => Str::limit($studentData['email'] ?? '', 255, '')],
            [
                'name' => Str::limit($studentData['name'], 255, ''),
                'phone_number' => $studentData['phone_number']
            ]
        );
    }

    private function studentProfile($student, $studentData)
    {
        $profileMethod = $student->profile()->exists() ? 'update' : 'create';

        $studentProfile = [
            'parent_name' => Str::limit($studentData['parent_name'], 255, ''),
            'parent_email' => Str::limit($studentData['parent_email'] ?? '', 255, ''),
            'level' => $this->level,
            'class' => Str::limit($studentData['class'] ?? '', 20, ''),
            'division' => Str::limit($studentData['division'] ?? '', 1, ''),
        ];

        return $student->profile()->{$profileMethod}($studentProfile);
    }
}
