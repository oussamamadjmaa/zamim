<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Traits\AdminStatsTrait;
use App\Http\Controllers\Backend\Traits\SchoolStatsTrait;
use App\Http\Controllers\Controller;
use Cache;
use Carbon\Carbon;
use hijri;
use Str;

class StatsController extends Controller
{
    use AdminStatsTrait, SchoolStatsTrait;
    /**
     * Display statistics based on the specified type and period.
     *
     * @param string $type
     * @param string $period
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats($type, $period)
    {
        abort_if(!request()->expectsJson(), 404);
        // Dynamically call the appropriate stats method based on the type
        $method = $type . 'StatsFor'. ucfirst(getRoutePrefix());

        return method_exists($this, $method) ? $this->{$method}($period) : abort(404);
    }

    /**
     * Generate statistics for a given period and data type.
     *
     * @param string $period
     * @param string $type
     * @param mixed $model
     * @param string $label
     * @param string $backgroundColor
     * @return \Illuminate\Http\JsonResponse
     */
    private function generateStats($period, $type, $model, $label, $backgroundColor)
    {
        // Retrieve date ranges and calculate counts
        $authId = auth()->id();
        $dateRanges = $this->getDateRanges($period);
        $routePrefix = getRoutePrefix();
        $dataCounts = Cache::remember("stats_{$type}_{$authId}_{$period}_{$routePrefix}", Carbon::now()->addMinute(), function () use ($dateRanges, $model, $period) {
            return $this->calculateCounts($dateRanges, $model, $period);
        });


        $options = [];

        $chartType = request()->get('type', 'bar');
        $version = request()->get('version', 1);

        if ($chartType == 'line') {
            $options = [
                'borderColor' => $version == 1 ? '#DCF3FD' : '#667080',
                'pointBackgroundColor' => '#D95D13',
                'pointRadius' => 6, // Increase point size
                'cubicInterpolationMode' => 'monotone', // Use monotone cubic Bezier curves
                'pointRadius' => $version == 1 ? [0, 6] : 0, // Set pointRadius for each data point
            ];
        }else {
            $options = [
                'borderColor' => 'transparent',
                'backgroundColor' => $this->backgroundColor($dataCounts->toArray(), $backgroundColor),
                'borderRadius' => 12,
                'barPercentage' => 0.64,
                'offset' => true,
            ];
        }
        // Prepare chart data
        $chartData = [
            'labels' => $this->convertToHijriDateRanges($dateRanges, $period),
            'datasets' => [
                array_merge(['label' => __($label), 'data' => $dataCounts, 'rtl' => (bool) config('app.direction')], $options),
            ],
        ];

        return response()->json([
            'id' => ucfirst($type) . 'CountChartJs'.$version,
            'periods' => $this->getAvailablePeriods(),
            'chartData' => $chartData
        ]);
    }

    /**
     * Calculate counts for a given model and date ranges.
     *
     * @param array $dateRanges
     * @param mixed $model
     * @return \Illuminate\Support\Collection
     */
    private function calculateCounts($dateRanges, $model, $period)
    {
        return collect($dateRanges)->map(function ($date) use ($model, $period) {
            $date = explode('-', $date);

            return tap(clone $model, function ($query) use ($date, $period) {
                $query->when(isset($date[0]), fn ($q) => $q->whereYear('created_at', $date[0]))
                    ->when(isset($date[1]), fn ($q) => $q->whereMonth('created_at', $date[1]))
                    ->when(isset($date[2]) && !in_array($period, ['last_year', 'this_year']), fn ($q) => $q->whereDay('created_at', $date[2]));
            })->count();
        });
    }

    /**
     * Get date ranges based on the specified period.
     *
     * @param string $period
     * @return \Illuminate\Support\Collection
     */
    private function getDateRanges($period)
    {
        // Validate the provided period against the available periods
        $validPeriods = $this->getAvailablePeriods();
        if (!in_array($period, array_keys($validPeriods))) {
            abort(404); // Invalid period
        }

       // Convert snake_case to PascalCase using Str::studly
        $methodName = 'get' . Str::studly($period) . 'DateRanges';

        // Call the appropriate method to get date ranges based on the period
        return $this->{$methodName}();
    }

    private function convertToHijriDateRanges($dateRanges, $period) {
        if (in_array($period, ['last_week', 'this_week'])) {
            $format = 'd F Y';
        }else {
            $format = 'F Y';
        }

        return $dateRanges->map(function($date) use($format) {
            return hijriDate($date, $format);
        });
    }

    /**
     * Get available periods.
     *
     * @return array
     */
    private function getAvailablePeriods()
    {
        return [
            'last_week' => __('Last week'),
            'this_week' => __('This week'),
            'last_year' => __('Last year'),
            'this_year' => __('This year'),
        ];
    }

    /**
     * Get date ranges for the last week.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getLastWeekDateRanges()
    {
        return collect(range(6, 0, -1))->map(function ($daysAgo) {
            return now()->subDays($daysAgo)->toDateString();
        });
    }

    /**
     * Get date ranges for this week.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getThisWeekDateRanges()
    {
        return collect(range(6, 0, -1))->map(function ($daysAgo) {
            return now()->endOfWeek()->subDays($daysAgo)->toDateString();
        });
    }

    /**
     * Get date ranges for the last year.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getLastYearDateRanges()
    {
        return collect(range(11, 0, -1))->map(function ($monthsAgo) {
            return now()->subMonths($monthsAgo)->format('Y-m');
        });
    }

    /**
     * Get date ranges for this year.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getThisYearDateRanges()
    {
        $hijriYear = Hijri::Date('Y', now());

        return collect(range(1, 12, +1))->map(function ($monthsAgo) use($hijriYear) {
            return Carbon::parse(Hijri::DateToGregorianFromDMY(01, $monthsAgo, $hijriYear))->format('Y-m-d');
        });
    }

    /**
     * Set background color based on data values.
     *
     * @param array $data
     * @param string $maxBg
     * @param string $defaultBg
     * @return array
     */
    private function backgroundColor($data, $maxBg = '#D95D13', $defaultBg = '#EDEDED')
    {
        // Find the index of the maximum value
        $maxIndex = array_search(max($data), $data);

        // Replace the maximum value with 'RED' and the rest with 'GRAY'
        return array_map(function ($value, $index) use ($maxIndex, $maxBg, $defaultBg) {
            return ($index === $maxIndex) ? $maxBg : $defaultBg;
        }, $data, array_keys($data));
    }
}
