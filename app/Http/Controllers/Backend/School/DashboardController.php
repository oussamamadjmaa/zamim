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
        parent::__construct();
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

        return view('backend.school.dashboard', compact('dashboardStats', 'dateRanges', 'periods', 'period'));
    }
}
