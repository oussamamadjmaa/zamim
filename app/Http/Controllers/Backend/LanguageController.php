<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    public function switch($lang){
        if(in_array($lang , ['ar', 'en'])){
            Cookie::queue('locale', $lang, 3600*24*7);
        }

        if(back()->getTargetUrl() == route($this->routePrefix.'.lang', $lang)){
            return redirect()->intended();
        }else{
            return back();
        }
        return back();
    }
}
