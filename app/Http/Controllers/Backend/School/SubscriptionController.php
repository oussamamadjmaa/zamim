<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionPaymentResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\School;
use App\Models\Subscription\Plan;
use App\Models\Subscription\SubscriptionPayment;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        parent::__construct();
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $school = auth()->user()->school;

        if($subscription = $school?->subscription) {
            $subscription = json_decode(SubscriptionResource::make($subscription->load('plan'))->toJson());
        }

        $paymentOnHold = $school->subscription_payments()->whereStatus(SubscriptionPayment::ON_HOLD)->count() > 0;

        $canRenew = !$paymentOnHold && $subscription;
        $canChangePlan = !$paymentOnHold && !$school->subscription?->isActive();

        return view('backend.school.subscription.index', compact('subscription', 'paymentOnHold', 'canRenew', 'canChangePlan'));
    }

    public function paymentHistory() {
        $subscriptionPayments = auth()->user()->school()->subscription_payments()->with('plan')->latest()->paginate(15)->withQueryString();

        return SubscriptionPaymentResource::collection($subscriptionPayments);
    }

    public function choosePlan(Request $request) {
        abort_if(auth()->user()->school->subscription?->isActive(), 404);

        $school = auth()->user()->school;

        //Check if user already has payment on hold
        $paymentOnHold = $school->subscription_payments()->whereStatus(SubscriptionPayment::ON_HOLD)->count();
        if ($paymentOnHold) {
            return redirect()->route('school.subscription.index');
        }

        $plans = Plan::all();

        return view('backend.school.subscription.choose-plan', compact('plans'));
    }

    public function checkout(Request $request) {
        $planId = $request->get('plan_id');

        if ($error = $request->get('error')) {
            return redirect()->route('school.subscription.checkout', ['plan_id' => $planId])->withErrors(['status' => $error]);
        }

        $school = auth()->user()->school;
        $subAction = !$planId || $school->subscription?->plan_id == $planId ? 'renew' : 'new';

        //Redirect if has active subscription and trying to checkout another plan
        if ($subAction == 'new' && $school->subscription?->isActive()) {
            return redirect()->route('school.subscription.index');
        }

        //Check if user already has payment on hold
        if ($school->subscription_payments()->whereStatus(SubscriptionPayment::ON_HOLD)->count()) {
            return redirect()->route('school.subscription.index');
        }

        //Get plan
        $plan = $subAction == 'renew' ? $school->subscription->plan : Plan::findOrFail($planId) ;

        return view('backend.school.subscription.checkout', compact('plan'));
    }

    public function processCheckout(Request $request) {
        $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'payment_method' => ['required', 'in:'. implode(array_keys(config('payment-methods')))],
        ]);

        $school = auth()->user()->school;

        abort_if($school->subscription?->isActive() && $request->plan_id != $school->subscription->plan_id, 403);

        $plan = Plan::find($request->plan_id);

        //Check if user already has payment on hold
        $paymentOnHold = $school->subscription_payments()->whereStatus(SubscriptionPayment::ON_HOLD)->count();
        if ($paymentOnHold) {
            return redirect()->route('school.subscription.index');
        }

        //Create new payment or continue from pending payment
        $lastPendingPayment = $school->subscription_payments()->where('status', SubscriptionPayment::PENDING)->wherePlanId($plan->id)->latest()->first();
        $subscriptionPayment = $lastPendingPayment ?: $this->createSubscriptionPayment($school, $plan);

        //Cancel pending payments if exists
        $school->subscription_payments()->whereStatus(SubscriptionPayment::PENDING)->where('id', '!=', $subscriptionPayment->id)->update(['status' => SubscriptionPayment::CANCELED, 'comment' => 'Canceled by user']);

        return $this->{'handle'.ucfirst($request->payment_method).'Payment'}($plan, $subscriptionPayment);
    }

    public function paymentStatus(SubscriptionPayment $subscriptionPayment) {
        abort_if($subscriptionPayment->payer_id != auth()->user()->school_id, 404);
        if (!in_array($subscriptionPayment->status, ['completed', 'failed', 'on_hold'])) {
            return redirect()->route('school.subscription.index');
        }

        return view('backend.school.subscription.payment_status', compact('subscriptionPayment'));
    }

    protected function handlePayfortPayment(Plan $plan, SubscriptionPayment $subscriptionPayment) {
        $callbackUrl = route('school.subscription.payment_callback', 'payfort');

        $payfortForm = $this->paymentService->createPaymentIntent($plan->price, $subscriptionPayment->merchant_reference, $plan->currency, $callbackUrl, $subscriptionPayment->customer_email, $plan->short_description);

        return view('backend.school.subscription.partials.payfort_payment', compact('payfortForm'));
    }

    protected function createSubscriptionPayment(School $school, Plan $plan)
    {
        return $school->subscription_payments()->create([
            'plan_id' => $plan->id,
            'payment_method' => 'payfort',
            'amount' => $plan->price,
            'currency' => $plan->currency,
            'customer_email' => $school->email,
            'subscription_interval' => $plan->billing_interval,
            'subscription_period' => $plan->billing_period,
            'billed_at' => Carbon::now(),
            'status' => SubscriptionPayment::PENDING,
            'initiated_at' => now()
        ]);
    }
}
