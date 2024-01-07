<?php

namespace App\Http\Controllers\Backend\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('backend.portal.dashboard');
    }
}
