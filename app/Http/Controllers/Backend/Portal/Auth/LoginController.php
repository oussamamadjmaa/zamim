<?php

namespace App\Http\Controllers\Backend\Portal\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendVerificationCodeNotification;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $maxAttempts = 3; // Maximum login attempts
    protected $decayMinutes = 2; // Lockout time in minutes

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('backend.portal.auth.login');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
    }

    public function login(Request $request)
    {
        // Apply rate limiting based on IP address
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $this->validateLogin($request);

        $user = User::where('email', $request->email)->whereIn('role', ['student', 'teacher'])->first();

        if ($user) {
            if (($user->last_email_code_at && now()->diffInMinutes($user->last_email_code_at) < 5)) {
                return redirect()->route('portal.login.verification')->with(['status' => __('Verification code has been sent to your email')]);
            }

            session()->put('user_id', $user->id);

            // Generate and send verification code
            $code = rand(100000, 999999); // You can use a more secure method to generate the code
            $user->update(['email_verification_code' => Hash::make($code), 'last_email_code_at' => now()]);

            // Send the code to the user's email (you need to implement this part)
            $user->notify(new SendVerificationCodeNotification($user, $code));

            // Clear the login attempts upon successful verification
            $this->clearLoginAttempts($request);

            // Redirect to a verification page
            return redirect()->route('portal.login.verification')->with(['status' => __('Verification code has been sent to your email')]);
        }

        $this->incrementLoginAttempts($request);
        return redirect()->back()->withInput()->withErrors(['email' => 'Invalid email.']);
    }

    public function showVerificationForm()
    {
        if (!$userId = session()->get('user_id')) {
            return redirect()->route('portal.login');
         }

        return view('backend.portal.auth.verification', ['user' => \App\Models\User::findOrFail($userId)]);
    }

    public function verifyCode(Request $request)
    {
        if (!$userId = session()->get('user_id')) {
           return redirect()->route('portal.login');
        }

         // Apply rate limiting based on IP address
         if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $user = \App\Models\User::whereIn('role', ['student', 'teacher'])->findOrFail($userId);

        $this->validate($request, [
            'code' => 'required',
        ]);

        if ($user && now()->diffInMinutes($user->last_email_code_at) <= 5 && Hash::check($request->code, $user->email_verification_code)) {
            // Verification successful, log the user in
            Auth::login($user, $request->remember ?: false);

            // Clear the verification code
            $user->update(['email_verification_code' => null, 'last_email_code_at' => null]);

            // Clear the login attempts upon successful verification
            $this->clearLoginAttempts($request);

            return redirect()->intended($this->redirectPath());
        }

        // Increment the login attempts upon unsuccessful verification
        $this->incrementLoginAttempts($request);

        // Invalid verification code
        return redirect()->back()->withInput()->withErrors(['code' => __('Invalid or expired verification code')]);
    }

    protected function redirectPath() {
        return route('portal.home');
    }
}
