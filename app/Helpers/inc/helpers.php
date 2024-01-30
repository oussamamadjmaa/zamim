<?php

use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Resources\SemesterResource;
use App\Models\Semester;

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
        if (is_string($value) && app()->getLocale() == 'ar') {
            $arabic_eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
            $arabic_western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

            return str_replace($arabic_western, $arabic_eastern, $value);
        }

        return $value;
    }
}

if(!function_exists('getSemesters')) {
    function getSemesters() {
        SemesterResource::withoutWrapping();
        return Cache::rememberForever('semesters', function() {
            return SemesterResource::collection(Semester::latest('start_date')->get());
        });
    }
}
