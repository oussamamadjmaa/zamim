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
use Str;

class SubscriptionController extends Controller
{
    protected $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $school = auth()->user()->school;

        if($subscription = $school?->subscription) {
            $subscription = json_decode(SubscriptionResource::make($subscription->load('plan'))->toJson());
        }

        $paymentOnHold = $school->subscription_payments()->whereIn('status', [SubscriptionPayment::ON_HOLD, SubscriptionPayment::IN_REVIEW])->count() > 0;

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

        //Check if user already has payment on hold or review
        $paymentOnHold = $school->subscription_payments()->whereIn('status', [SubscriptionPayment::ON_HOLD, SubscriptionPayment::IN_REVIEW])->count();
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

        //Check if user already has payment on hold or review
        if ($school->subscription_payments()->whereIn('status', [SubscriptionPayment::ON_HOLD, SubscriptionPayment::IN_REVIEW])->count()) {
            return redirect()->route('school.subscription.index');
        }

        //Get plan
        $plan = $subAction == 'renew' ? $school->subscription->plan : Plan::findOrFail($planId) ;

        return view('backend.school.subscription.checkout', compact('plan'));
    }

    public function processCheckout(Request $request) {
        $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'payment_method' => ['required', 'in:'. implode(',', array_keys(config('payment-methods')))],
            'image' => 'required_if:payment_method,bank_transfer|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'image.required_if' => __('Bank transfer receipt image is required')
        ]);

        $school = auth()->user()->school;

        abort_if($school->subscription?->isActive() && $request->plan_id != $school->subscription->plan_id, 403);

        $plan = Plan::find($request->plan_id);

        //Check if user already has payment on hold or review
        $paymentOnHold = $school->subscription_payments()->whereIn('status', [SubscriptionPayment::ON_HOLD, SubscriptionPayment::IN_REVIEW])->count();
        if ($paymentOnHold) {
            return redirect()->route('school.subscription.index');
        }

        //Create new payment or continue from pending payment
        $lastPendingPayment = $school->subscription_payments()->wherePaymentMethod($request->payment_method)->where('status', SubscriptionPayment::PENDING)->wherePlanId($plan->id)->latest()->first();
        $subscriptionPayment = $lastPendingPayment ?: $this->createSubscriptionPayment($school, $plan, $request->payment_method);

        //Cancel pending payments if exists
        $school->subscription_payments()->whereStatus(SubscriptionPayment::PENDING)->where('id', '!=', $subscriptionPayment->id)->update(['status' => SubscriptionPayment::CANCELED, 'comment' => 'User initiated another payment']);

        if ($request->payment_method == 'bank_transfer' && $request->hasFile('image')) {
            $subscriptionPayment = $this->uploadAndSaveReceipt($subscriptionPayment, $request->file('image'));
        }

        return $this->{'handle'.Str::studly($request->payment_method).'Payment'}($plan, $subscriptionPayment);
    }

    public function paymentStatus(SubscriptionPayment $subscriptionPayment) {
        abort_if($subscriptionPayment->payer_id != auth()->user()->school_id, 404);
        if (!in_array($subscriptionPayment->status, ['completed', 'failed', 'on_hold', 'in_review'])) {
            return redirect()->route('school.subscription.index');
        }

        return view('backend.school.subscription.payment_status', compact('subscriptionPayment'));
    }

    protected function handlePayfortPayment(Plan $plan, SubscriptionPayment $subscriptionPayment) {
        $callbackUrl = route('school.subscription.payment_callback', 'payfort');

        $payfortForm = $this->paymentService->createPaymentIntent($plan->price, $subscriptionPayment->merchant_reference, $plan->currency, $callbackUrl, $subscriptionPayment->customer_email, 'Plan subscription payment #'.$subscriptionPayment->id);

        return view('backend.school.subscription.partials.payfort_payment', compact('payfortForm'));
    }

    protected function handleBankTransferPayment(Plan $plan, SubscriptionPayment $subscriptionPayment) {

        $subscriptionPayment->status = SubscriptionPayment::IN_REVIEW;
        $subscriptionPayment->save();

        return redirect()->route('school.subscription.payment.status', $subscriptionPayment->id);
    }

    protected function createSubscriptionPayment(School $school, Plan $plan, $paymentMethod)
    {
        return $school->subscription_payments()->create([
            'plan_id' => $plan->id,
            'payment_method' => $paymentMethod,
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

    private function uploadAndSaveReceipt(SubscriptionPayment $subscriptionPayment, $receipt) {
        $path = $receipt->store('bank_transfer_receipts/'.date('Y-m'), 'public');
        $subscriptionPayment->receipt()->create([
            'path' => $path,
            'file_size' => $receipt->getSize(),
            'file_type' => $receipt->getMimeType(),
            'type' => 'receipt'
        ]);

        return $subscriptionPayment;
    }
}
