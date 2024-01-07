<?php

namespace App\Http\Controllers\Backend\Traits;

trait SchoolStatsTrait {
    /**
     * Display statistics for students.
     *
     * @param string $period
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentsStatsForSchool($period)
    {
        return $this->generateStats($period, 'students', auth()->user()->school->students(), 'Students number', '#D95D13');
    }

    /**
     * Display statistics for teachers.
     *
     * @param string $period
     * @return \Illuminate\Http\JsonResponse
     */
    public function teachersStatsForSchool($period)
    {
        return $this->generateStats($period, 'teachers', auth()->user()->school->teachers(), 'Teachers number', '#0864AF');
    }
}
