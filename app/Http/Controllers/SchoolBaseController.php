<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as ControllersController;

class SchoolBaseController extends ControllersController
{
    public function __construct()
    {
        view()->share([
            'routePrefix' => 'school',
            'sidebarLinks' => $this->sidebarLinks()
        ]);
    }

    private function sidebarLinks() {
        return [
            $this->sidebarLink('Home', route('school.dashboard'), 'home-1'),
            $this->sidebarLink('Students', route('school.students.index'), 'cash'),
            $this->sidebarLink('Teachers', route('school.teachers.index'), 'cash'),
        ];
    }

    private function sidebarLink($title, $link, $icon, $hasAccess = true) {
        return [
            'title' => __($title),
            'link'  => $link,
            'icon' => $icon,
            'has-access' => (bool) $hasAccess
        ];
    }
}
