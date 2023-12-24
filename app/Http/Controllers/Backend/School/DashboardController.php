<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\SchoolBaseController;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DashboardController extends SchoolBaseController
{
    public function index() {
        $dashboardStats = [
            $this->newStat('Students number', Student::count(), 'bg-light-blue'),
            $this->newStat('Teachers number', Teacher::count(), 'bg-light-orange')
        ];

        return view('backend.school.dashboard', compact('dashboardStats'));
    }

    private function newStat($title, $count, $bgClass) {
        return [
            'title' => __($title),
            'count' => $count,
            'bg-class' => $bgClass
        ];
    }
}
