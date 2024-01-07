<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Route;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class SchoolSubscription
{
    protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->isAuthorized()) {
            return abort(404);
        }

        if ($this->isAllowedRoute() || $this->hasActiveSubscription()) {
            return $next($request);
        }

        return $this->handleSubscriptionNotActive($request);
    }

    private function isAuthorized()
    {
        return $this->auth->guard('school')->check() || (
            $this->auth->guard('web')->check() &&
            auth()->user()->school &&
            in_array(auth('web')->user()->role, ['supervisor'])
        );
    }

    private function isAllowedRoute()
    {
        return Route::is($this->allowedRoutes());
    }

    private function hasActiveSubscription()
    {
        $subscription = auth()->user()->school->subscription;

        return $subscription && $subscription->isActive();
    }

    private function handleSubscriptionNotActive($request)
    {
        if (!auth('school')->check()) {
            return abort(403, __('Subscription not active'));
        }

        return $request->expectsJson()
            ? response()->json(['message' => 'Subscription not active'], 403)
            : to_route('school.subscription.index');
    }

    private function allowedRoutes()
    {
        return [
            'school.logout',
            'school.subscription.*',
            'school.notifications.*',
            'school.profile.*'
        ];
    }

}
