<?php

namespace App\Providers;

use App\Models\FrontendContent;
use Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Log;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->shareViewData(getRoutePrefix());
        });

    }

    ///
    private function shareViewData($routePrefix)
    {
        view()->share([
            'routePrefix' => $routePrefix,
            'sidebarLinks' => $this->getSidebarLinks($routePrefix),
            'viteIncludes' => $this->getViteIncludes($routePrefix),
            'currentSemester' => json_decode(json_encode(getCurrentSemester())),
            'frontendContent' => $this->getFrontendContent()
        ]);


    }

    private function getFrontendContent() {
        try {
            return Cache::rememberForever('frontend_contents', function() {
                return FrontendContent::all();
            });
        } catch (\Exception $e) {
            Log::alert('Failed to get data from frontend_contents table: ' . $e->getMessage());

            return (object)[];
        }
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
            $this->sidebarLink('Dashboard', route('admin.dashboard'), 'admin.dashboard', 'home-1'),
            $this->sidebarLink('Statistics', route('admin.statistics.index'), 'admin.statistics.*', 'bar-graph-3'),
            $this->sidebarLink('Subscriptions', route('admin.subscriptions.index'), 'admin.subscriptions.*', 'cash'),
            $this->sidebarLink('Semesters', route('admin.semesters.index'), 'admin.semesters.*', 'calendar-1'),
            $this->sidebarLink('Profile', route('admin.profile.index'), 'admin.profile.*', 'user-2'),
        ];
    }

    private function SchoolSidebarLinks($route) {
        return [
            $this->sidebarLink('Dashboard', route('school.dashboard'), 'school.dashboard', 'home-1'),
            $this->sidebarLink('Students', route('school.students.index'), 'school.students.*', 'group'),
            $this->sidebarLink('Teachers', route('school.teachers.index'), 'school.teachers.*', 'users'),
            $this->sidebarLink('School Radio', route('school.radios.index'), 'school.radios.*', 'radio'),
            // $this->sidebarLink('Activities', route('school.activities.index'), 'school.activities.*', 'grid-apps'),
            $this->sidebarLink('Subscription', route('school.subscription.index'), 'school.subscription.*', 'cash'),
            $this->sidebarLink('Profile', route('school.profile.index'), 'admin.profile.*', 'user-2'),
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

    private function sidebarLink($title, $link, $routeForActiveClass, $icon, $hasAccess = true) {
        return [
            'title' => __($title),
            'link'  => $link,
            'icon' => $icon,
            'has-access' => (bool) $hasAccess,
            'route-named' => $routeForActiveClass
        ];
    }

}
