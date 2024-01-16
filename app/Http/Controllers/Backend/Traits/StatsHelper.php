<?php

namespace App\Http\Controllers\Backend\Traits;

use Alkoumi\LaravelHijriDate\Hijri;
use Carbon\Carbon;

class StatsHelper {
    const TODAY = 'today';
    const YESTERDAY = 'yesterday';
    const LAST_WEEK = 'last_week';
    const THIS_WEEK = 'this_week';
    const LAST_MONTH = 'last_month';
    const THIS_MONTH = 'this_month';
    const LAST_YEAR = 'last_year';
    const THIS_YEAR = 'this_year';

    public static function getPeriods()
    {
        return collect([
            self::TODAY =>  __('Today'),
            self::YESTERDAY =>  __('Yesterday'),
            self::LAST_WEEK => __('Last week'),
            self::THIS_WEEK => __('This week'),
            self::LAST_MONTH => __('Last month'),
            self::THIS_MONTH => __('This month'),
            self::LAST_YEAR => __('Last year'),
            self::THIS_YEAR => __('This year'),
        ]);
    }

    public static function getDateRanges($period, $periods = null) {
        $periods = $periods?: self::getPeriods()->toArray();

        if (!array_key_exists($period, $periods)) {
            return null;
        }

        list($hijriMonth, $hijriYear) = explode('/', Hijri::Date('m/Y', now()));

        $thisMonthStart = Carbon::parse(Hijri::DateToGregorianFromDMY(01, $hijriMonth, $hijriYear));
        $endThisMonth = Carbon::parse(Hijri::DateToGregorianFromDMY(01, $hijriMonth+1, $hijriYear))->subDay();
        $thisYearStart = Carbon::parse(Hijri::DateToGregorianFromDMY(01, 01, $hijriYear));
        $endThisYear = Carbon::parse(Hijri::DateToGregorianFromDMY(01, 01, $hijriYear+1))->subDay();

        switch ($period) {
            case self::TODAY:
                return [self::formatDate(now()), self::formatDate(now())];
            case self::YESTERDAY:
                return [self::formatDate(now()->subDay()), self::formatDate(now()->subDay())];
            case self::LAST_WEEK:
                return [self::formatDate(now()->subWeek()), self::formatDate(now())];
            case self::THIS_WEEK:
                return [self::formatDate(now()->startOfWeek()), self::formatDate(now()->endOfWeek())];
            case self::LAST_MONTH:
                return [self::formatDate(now()->subMonth()), self::formatDate(now())];
            case self::THIS_MONTH:
                return [self::formatDate($thisMonthStart), self::formatDate($endThisMonth)];
            case self::LAST_YEAR:
                return [self::formatDate(now()->subYear()), self::formatDate(now())];
            case self::THIS_YEAR:
                return [self::formatDate($thisYearStart), self::formatDate($endThisYear)];
            default:
                return null;
        }
    }

    public static function formatDate($date) {
        return $date->toDateString();
    }

    public static function newStat($title, $model, $dateRanges, $route, $bgClass = 'bg-light-blue') {
        $count = $model->whereBetween('created_at', $dateRanges)->count();
        return [
            'title' => __($title),
            'count' => transNumber((string) $count),
            'link' => $route ? route($route) : '#',
            'bg-class' => $bgClass,
        ];
    }
}
