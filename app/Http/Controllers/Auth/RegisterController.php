<?php

namespace App\Http\Controllers\Auth;

use AmazonPaymentServicesSdk\AmazonPaymentServices\Exceptions\APSException;
use AmazonPaymentServicesSdk\AmazonPaymentServices\Merchant\APSMerchant;
use AmazonPaymentServicesSdk\AmazonPaymentServices\Model\APSResponse;
use AmazonPaymentServicesSdk\FrontEndAdapter\Core\ResponseHandler;
use AmazonPaymentServicesSdk\FrontEndAdapter\Payments\CCRedirect;
use AmazonPaymentServicesSdk\FrontEndAdapter\Payments\CCStandard;
use AmazonPaymentServicesSdk\FrontEndAdapter\Payments\InstallmentsCCStandard;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Log;
use Str;

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

    public function showRegistrationForm()
    {
        // APSMerchant::setMerchantParams(config('aps-config'));

        // $paymentData =  [
        //     'merchant_reference' => 'ZAMIMSUB-'.rand(1000, 99999),
        //     'amount'            => 1500.00,
        //     'currency'          => 'AED',
        //     'language'          => 'en',
        //     'customer_email'    => 'test@aps.com',

        //     'order_description' => 'Test product 1',
        // ];

        // try {
        //     $button = (new CCRedirect())
        //     ->setPaymentData($paymentData)
        //     ->usePurchaseCommand()
        //     ->setCallbackUrl(route('web.redirect-aps-payment'))
        //     ->render([
        //             'button_text'   => 'Place order with Purchase'
        //     ]);
        // } catch (APSException $e) {
        //     // do your thing here to handle this error
        // }
        return view('auth.register');
    }

    public function redirectApsPayment(Request $request)
    {
        APSMerchant::setMerchantParams(config('services.aps'));

        $orderNumber = $request->merchant_reference ?? '';
        // get your order data based on merchant_reference

        // sample app approach is to load the order data from a sample file
        $paymentData =  [
            'merchant_reference' => $orderNumber,
            'language'          => 'en',
        ];

        try {
            (new ResponseHandler($paymentData))
                ->onSuccess(function (APSResponse $responseHandlerResult) use($paymentData) {
                    // the payment transaction was a success
                    // do your thing and process the response

                    Log::alert($paymentData);
                    Log::alert($responseHandlerResult->getResponseData());
                    Log::alert($responseHandlerResult->isSuccess());
                    // redirect user to the success page
                    // header('Location: ' . route('web.register') . '?' . $responseHandlerResult->getRedirectParams());
                    // exit;
                })
                ->onError(function (APSResponse $responseHandlerResult) {
                    // the payment failed
                    // process the response

                    // redirect user to the error page
                    Log::alert('errorrrr');
                    header('Location: ' . route('web.register') . '?' . $responseHandlerResult->getRedirectParams());
                    exit;
                })
                ->onHtml(function (string $htmlContent, APSResponse $responseHandlerResult) {
                    // the payment requires 3ds verification

                    if (!($merchantParams['3ds_modal'] ?? false)) {
                        if ($responseHandlerResult->isStandardImplementation()) {
                            // this is the standard implementation

                            // although standard checkout is inside a popup
                            // user wants 3ds verification to be redirection of main page

                            // redirect user to the 3ds redirection page,
                            // where it will detect that it is inside an iframe
                            // and jump out from the iframe to be able to redirect the user
                            // to 3ds in the navigation bar
                            return redirect(url('3d_trasnaction?' . $responseHandlerResult->getRedirectParams()));
                        }

                        // we simply redirect the user to the 3ds verification page
                        return redirect($responseHandlerResult->get3dsUrl());
                    } else {
                        // open 3ds verification inside the iframe (print html code)
                        echo $htmlContent;
                    }
                })
                ->handleResponse();
        } catch (APSException $e) {
            return "Wtf error happened bro";
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $step = (int) $request->input('step', 1);
        $last_step = 3;
        $step = ($step < 1 || $step > $last_step) ? 1 : $step;

        $this->validator($request->all(), $step)->validate();

        if ($step != 3) {
            return response()->json(['next_step' => $step + 1]);
        }
        // event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        // if ($response = $this->registered($request, $user)) {
        //     return $response;
        // }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $step)
    {
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'accept_terms' => ['accepted'],
        ];

        if ($step > 1) {
            $rules = array_merge($rules, [
                'city' => ['required', 'string', 'max:70'],
                'name' => ['required', 'string', 'max:255'],
                'accreditation_number' => ['required', 'string', 'max:255'],
                'mod_name' => ['required', 'string', 'max:255'],
                'id_number' => ['required', 'string', 'max:255'],
                'acknowledgment' => ['accepted'],
            ]);
        }



        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
