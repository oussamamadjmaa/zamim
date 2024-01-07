<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Auth;
use Cache;
use Illuminate\Http\Request;
use Str;

class SchoolController extends Controller
{
    public function loginAs(School $school) {
        return view('backend.admin.auth.login_as', compact('school'));
    }

    public function processLoginAs(Request $request, School $school) {
        $request->validate([
            'password' => ['required', 'string']
        ]);

        //
        $adminPassword = Auth::user()->password;
        $isPasswordCorrect = \Hash::check($request->password, $adminPassword);

        if (!$isPasswordCorrect) {
            return redirect()->back()->withErrors(['password' => __('Incorrect password')]);
        }

        //if password is correct do this
        $loginCode = Str::random(40);
        $timestamp = now()->getTimestamp();

        Cache::put('login_school_id_'. request()->ip() . '_' . $loginCode .'_'. $timestamp, $school->id, now()->addMinute());

        return redirect()->route('school.login_as', [$loginCode, 'timestamp' => $timestamp]);
    }
}
