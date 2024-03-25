<?php

use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Resources\SemesterResource;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;

if (!function_exists('getRoutePrefix')) {
    function getRoutePrefix() {
        $urlParts = explode('.', $_SERVER['HTTP_HOST'] ?? '');
        $routePrefix = count($urlParts) > 2 ? $urlParts[0] : 'web';
        $routePrefix = $routePrefix == 'app' ? 'school' : ($routePrefix == 'www' ? 'web' : $routePrefix);

        return $routePrefix;
    }
}

if (!function_exists('hijriDate')) {
    function hijriDate($date, $format = 'l ، j F ، Y') {
        $method = app()->getLocale() == 'ar' ? 'DateIndicDigits' : 'Date';
        return Hijri::{$method}($format, $date);
    }
}

if (!function_exists('transNumber')) {
    function transNumber($value){
        if ((is_string($value) || is_numeric($value)) && app()->getLocale() == 'ar') {
            $arabic_eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
            $arabic_western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

            return str_replace($arabic_western, $arabic_eastern, $value);
        }

        return $value;
    }
}

if(!function_exists('getSemesters')) {
    function getSemesters() {
        return Cache::rememberForever('semesters', function() {
            return SemesterResource::collection(Semester::latest('start_date')->get());
        });
    }
}

if(!function_exists('getCurrentSemester')) {
    function getCurrentSemester() {
        try {
            $semesters = getSemesters();
        } catch (\Throwable $th) {
            return new Semester();
        }

        if ($semesterId = session()->get('selected_semester_id')) {
            $selectedSemester = $semesters->where('id', $semesterId)
                                ->first();

            if ($selectedSemester) {
                return $selectedSemester;
            }
        }

        $currentDate = Carbon::now();
        $currentSemester = $semesters->where('start_date', '<=', $currentDate)
                                ->where('end_date', '>=', $currentDate)
                                ->first();

        if ($currentSemester) {
            session()->put('selected_semester_id', $currentSemester->id);
            return $currentSemester;
        }

        $upcomingSemester = $semesters->where('start_date', '>', $currentDate)
                                    ->sortBy('start_date')
                                    ->first();

        if ($upcomingSemester) {
            session()->put('selected_semester_id', $upcomingSemester->id);
            return $upcomingSemester;
        }

        $pastSemester = $semesters->where('end_date', '<', $currentDate)
                            ->sortByDesc('end_date')
                            ->first();

        if ($pastSemester) {
            session()->put('selected_semester_id', $pastSemester->id);
            return $pastSemester;
        }

        return new Semester();
    }
}

if(!function_exists('dateRangeFormatter')) {
    function dateRangeFormatter($startDate, $endDate, $seperator = '-') {
        $locale = app()->getLocale();
        [$year, $month, $day] = explode($seperator, $startDate);
        [$endYear, $endMonth, $endDay] = explode($seperator, $endDate);


        if ($year == $endYear && $month == $endMonth) {
            return $locale == 'ar' ?"{$day}-{$year}/{$month}/{$endDay}" : "{$day}-{$endDay}/{$month}/{$year}";
        }

        if ($year == $endYear) {
            return $locale == 'ar' ? "{$month}/{$day} - {$year}/{$endMonth}/{$endDay}" : "{$day}/{$month} - {$endDay}/{$endMonth}/{$year}";
        }

        return $locale == 'ar' ? "{$year}/{$month}/{$day} - {$endYear}/{$endMonth}/{$endDay}" : "{$day}/{$month}/{$year} - {$endDay}/{$endMonth}/{$endYear}";
    }
}
