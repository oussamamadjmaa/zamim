<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Subscription\Plan;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request)
    {
        $planKey = $request->get('plan');
        if (!$planKey || $plan = !Plan::where('key', $planKey)->exists()) {
            return to_route('school.choose-plan');
        }

        if (!session()->get('registerationPlanKey')) {
            session()->put('registerationPlanKey', $planKey);
        }

        return view('auth.register', compact('plan'));
    }

    public function register(Request $request)
    {
        abort_if(!$planKey = session()->get('registerationPlanKey'), 403);

        $step = (int) $request->input('step', 1);
        $last_step = 2;
        $step = ($step < 1 || $step > $last_step) ? 1 : $step;

        $this->validator($request->all(), $step)->validate();

        if ($step < $last_step) {
            return response()->json(['next_step' => $step + 1]);
        }
        $plan = Plan::where('key', $planKey)->firstOrFail();

        event(new Registered($school = $this->create($request->all())));
        $this->guard('school')->login($school);

        $redirectTo = route('school.subscription.checkout', ['payment', 'plan_id' => $plan->id]);

        return response()->json(['next_step' => 3, 'redirect_to' => $redirectTo]);
    }

    protected function validator(array $data, $step)
    {
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:schools'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'accept_terms' => ['accepted'],
        ];

        if ($step > 1) {
            $rules = array_merge($rules, [
                'name' => ['required', 'string', 'max:255'],
                'level' => ['required', 'string', 'in:primary,middle,secondary'],
                'city' => ['required', 'string', 'max:70'],
                'accreditation_number' => ['required', 'string', 'max:255'],
                'mod_name' => ['required', 'string', 'max:255'],
                'id_number' => ['required', 'string', 'max:255'],
                'acknowledgment' => ['accepted'],
            ]);
        }

        return Validator::make($data, $rules);
    }


    protected function create(array $data)
    {
        return School::create([
            'name' => $data['name'],
            'level' => $data['level'],
            'email' => $data['email'],
            'city' =>  $data['city'],
            'accreditation_number' =>  $data['accreditation_number'],
            'mod_name' =>  $data['mod_name'],
            'id_number' =>  $data['id_number'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
