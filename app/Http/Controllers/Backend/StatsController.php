<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Traits\AdminStatsTrait;
use App\Http\Controllers\Backend\Traits\SchoolStatsTrait;
use App\Http\Controllers\Controller;
use Cache;
use Carbon\Carbon;
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
        // Dynamically call the appropriate stats method based on the type
        $method = $type . 'StatsFor'. ucfirst($this->routePrefix);

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
        $dataCounts = Cache::remember("stats_{$type}_{$authId}_{$period}_{$this->routePrefix}", Carbon::now()->addMinute(), function () use ($dateRanges, $model) {
            return $this->calculateCounts($dateRanges, $model);
        });


        $options = [];

        $type = request()->get('type', 'bar');
        $version = request()->get('version', 1);

        if ($type == 'line') {
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
            'labels' => $dateRanges,
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
    private function calculateCounts($dateRanges, $model)
    {
        return collect($dateRanges)->map(function ($date) use ($model) {
            $date = explode('-', $date);

            return tap(clone $model, function ($query) use ($date) {
                $query->when(isset($date[0]), fn ($q) => $q->whereYear('created_at', $date[0]))
                    ->when(isset($date[1]), fn ($q) => $q->whereMonth('created_at', $date[1]))
                    ->when(isset($date[2]), fn ($q) => $q->whereDay('created_at', $date[2]));
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
        return collect(range(11, 0, -1))->map(function ($yearsAgo) {
            return now()->endOfYear()->subMonths($yearsAgo)->format('Y-m');
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
