<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;

class SchoolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        auth()->shouldUse('school');

        config()->set('auth.defaults.passwords', 'schools');

        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return url(route('school.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        });

        return $next($request);
    }
}
