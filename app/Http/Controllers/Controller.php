<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $routePrefix;

    public function __construct()
    {
        $urlParts = explode('.', $_SERVER['HTTP_HOST'] ?? '');
        $routePrefix = $urlParts > 2 ? $urlParts[0] : 'web';
        $this->routePrefix = $routePrefix == 'app' ? 'school' : $routePrefix;

        $this->shareViewData($this->routePrefix);
    }

    private function shareViewData($routePrefix)
    {
        view()->share([
            'routePrefix' => $routePrefix,
            'sidebarLinks' => $this->getSidebarLinks($routePrefix),
            'viteIncludes' => $this->getViteIncludes($routePrefix),
        ]);
    }

    private function getSidebarLinks($routePrefix)
    {
        $method = $routePrefix . 'SidebarLinks';
        return method_exists($this, $method) ? $this->$method(request()->route() ?? null) : [];
    }

    private function getViteIncludes($routePrefix)
    {
        $method = $routePrefix . 'ViteIncludes';
        return method_exists($this, $method) ? $this->$method() : [];
    }

    private function AdminsidebarLinks($route) {
        return [
            $this->sidebarLink('Dashboard', route('admin.dashboard'), $route?->named('admin.dashboard'), 'home-1'),
            $this->sidebarLink('Statistics', route('admin.statistics.index'), $route?->named('admin.statistics.*'), 'bar-graph-3'),
            $this->sidebarLink('Subscriptions', route('admin.subscriptions.index'), $route?->named('admin.subscriptions.*'), 'cash'),
            $this->sidebarLink('Profile', route('admin.profile.index'), $route?->named('admin.profile.*'), 'user-2'),
        ];
    }

    private function SchoolSidebarLinks($route) {
        return [
            $this->sidebarLink('Dashboard', route('school.dashboard'), $route?->named('school.dashboard'), 'home-1'),
            $this->sidebarLink('Students', route('school.students.index'), $route?->named('school.students.*'), 'group'),
            $this->sidebarLink('Teachers', route('school.teachers.index'), $route?->named('school.teachers.*'), 'users'),
            $this->sidebarLink('School Radio', route('school.radios.index'), $route?->named('school.radios.*'), 'radio'),
            $this->sidebarLink('Activities', route('school.activities.index'), $route?->named('school.activities.*'), 'grid-apps'),
            $this->sidebarLink('Subscription', route('school.subscription.index'), $route?->named('school.subscription.*'), 'cash'),
            $this->sidebarLink('Profile', route('school.profile.index'), $route?->named('admin.profile.*'), 'user-2'),
        ];
    }

    private function AdminViteIncludes() {
        return [
            'resources/vue_backend_assets/js/app_admin.js'
        ];
    }

    private function SchoolViteIncludes() {
        return [
            'resources/vue_backend_assets/js/app.js'
        ];
    }

    private function sidebarLink($title, $link, $isActive, $icon, $hasAccess = true) {
        return [
            'title' => __($title),
            'link'  => $link,
            'icon' => $icon,
            'has-access' => (bool) $hasAccess,
            'is-active' => $isActive
        ];
    }

}
