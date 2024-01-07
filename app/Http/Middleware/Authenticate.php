<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->customRedirectTo($request, $guards)
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function customRedirectTo($request, $guards)
    {
        if (! $request->expectsJson()) {
            $urlParts = explode('.', $_SERVER['HTTP_HOST'] ?? '');
            $routePrefix = $urlParts > 2 ? $urlParts[0] : 'web';
            $routePrefix = $routePrefix == 'app' ? 'school' : $routePrefix;

            return route($routePrefix.'.login');
        }
    }
}
