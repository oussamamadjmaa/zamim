<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($tab = "change_password") {
        return view('backend.profile.index', compact('tab'));
    }

    public function update(Request $request, $tab) {
        if($tab == 'change_password') {
            $request->validate([
                'current_password' => ['required', function ($attribute, $value, $fail)  {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail(__("Current password isn't correct"));
                    }
                }],
                'password' => ['required','confirmed','min:8', function ($attribute, $value, $fail)  {
                    if (Hash::check($value, auth()->user()->password)) {
                        return $fail(__('The new password must be different from the current one'));
                    }
                }],
            ]);

            $user = auth()->user();
            $user->password = bcrypt($request->password);
            $user->save();
        }else if ($tab == 'general') {

        }

        return response()->json([
            'status' => 200,
            'message' => __('Data updated successfully')
        ]);
    }
}
