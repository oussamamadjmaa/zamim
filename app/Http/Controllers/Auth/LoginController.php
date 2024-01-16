<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Cache;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'loginAs']);
    }


    public function loginAs(Request $request, $loginCode) {
        abort_if(!$timestamp = $request->get('timestamp'), 404);

        if ($schoolId = Cache::pull('login_school_id_'.$request->ip().'_'.$loginCode.'_'. $timestamp)) {
            return $this->loginAsSchool($request, $schoolId);
        }

        return abort(404);
    }

    protected function loginAsSchool($request, $schoolId) {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        auth()->guard('school')->loginUsingId($schoolId);
        $request->session()->regenerate();

        return redirect()->route('school.dashboard');
    }
}
