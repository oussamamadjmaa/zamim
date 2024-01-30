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

class TeachersImport implements OnEachRow, WithHeadingRow
{
    protected $school;

    public function __construct(School $school)
    {
        $this->school = $school;
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
            $student = $this->updateOrCreateTeacher($studentData);

            session()->increment('imported_teachers');
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
        ]);
    }

    private function updateOrCreateTeacher($studentData)
    {
        return $this->school->teachers()->withTrashed()->updateOrCreate(
            ['email' => Str::limit($studentData['email'] ?? '', 255, '')],
            [
                'name' => Str::limit($studentData['name'], 255, ''),
                'phone_number' => $studentData['phone_number']
            ]
        );
    }
}
