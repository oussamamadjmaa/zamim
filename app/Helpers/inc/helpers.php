<?php

use Alkoumi\LaravelHijriDate\Hijri;

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
