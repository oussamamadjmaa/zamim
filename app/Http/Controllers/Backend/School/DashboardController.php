<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Backend\Traits\StatsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $statsHelper;

    public function __construct(StatsHelper $statsHelper)
    {
        $this->statsHelper = $statsHelper;
    }

    public function index() {
        $school = auth()->user()->school;
        $periods = $this->statsHelper->getPeriods()->toArray();

        $dateRanges = $this->statsHelper->getDateRanges($period = request()->get('period', 'last_month'), $periods);

        if (!$dateRanges) {
            return redirect()->route('school.dashboard');
        }

        $betweenDateRanges = [$dateRanges[0], date('Y-m-d', strtotime($dateRanges[1] . ' + 1 day'))];

        $dashboardStats = [
            $this->statsHelper->newStat('Students number', $school->students(), $betweenDateRanges, 'school.students.index'),
            $this->statsHelper->newStat('Teachers number', $school->teachers(), $betweenDateRanges, 'school.teachers.index', 'bg-light-orange'),
            $this->statsHelper->newStat('Activities number', $school->activities(), $betweenDateRanges, 'school.activities.index'),
        ];

        $hijriDateRanges = [hijriDate($dateRanges[0], 'd F Y'), hijriDate($dateRanges[1], 'd F Y')];

        return view('backend.school.dashboard', compact('dashboardStats', 'dateRanges', 'hijriDateRanges', 'periods', 'period'));
    }
}
