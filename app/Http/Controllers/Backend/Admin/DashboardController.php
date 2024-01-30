<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Backend\Traits\StatsHelper;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Radio;
use App\Models\School;
use App\Models\Subscription\PlanSubscription;

class DashboardController extends Controller
{
    protected $statsHelper;

    public function __construct(StatsHelper $statsHelper)
    {
        $this->statsHelper = $statsHelper;
    }

    public function index() {
        $periods = $this->statsHelper->getPeriods()->toArray();

        $dateRanges = $this->statsHelper->getDateRanges($period = request()->get('period', 'last_month'), $periods);

        if (!$dateRanges) {
            return redirect()->route('school.dashboard');
        }

        $betweenDateRanges = [$dateRanges[0], date('Y-m-d', strtotime($dateRanges[1] . ' + 1 day'))];

        $dashboardStats = [
            $this->statsHelper->newStat('Registered schools', School::query(), $betweenDateRanges, 'admin.subscriptions.all'),
            $this->statsHelper->newStat('Active subscriptions', PlanSubscription::active(), $betweenDateRanges, 'admin.subscriptions.all', 'bg-light-orange'),
            $this->statsHelper->newStat('Radios', Radio::query(), $betweenDateRanges, null),
            $this->statsHelper->newStat('Activities', Activity::query(), $betweenDateRanges, null, 'bg-light-orange'),
        ];

        $hijriDateRanges = [hijriDate($dateRanges[0], 'd F Y'), hijriDate($dateRanges[1], 'd F Y')];

        return view('backend.admin.dashboard', compact('dashboardStats', 'dateRanges', 'hijriDateRanges', 'periods', 'period'));
    }
}
