<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscription\Plan;
use Illuminate\Http\Request;

class ChoosePlanController extends Controller
{
    public function index() {
        $plans = Plan::all();

        return view('web.choose-plan', compact('plans'));
    }
}
