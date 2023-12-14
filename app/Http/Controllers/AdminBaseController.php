<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as ControllersController;

class AdminBaseController extends ControllersController
{
    public function __construct()
    {
        view()->share([
            'routePrefix' => 'admin',
        ]);
    }
}
