<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionPaymentResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\School;
use App\Models\Subscription\Plan;
use App\Models\Subscription\PlanSubscription;
use App\Models\Subscription\SubscriptionPayment;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('backend.admin.subscriptions.index');
    }

    public function subscriptions(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->getSubscriptions($request);
        }

        return view('backend.admin.subscriptions.all');
    }

    public function paymentsHistory(Request $request, School $school = null)
    {
        if ($request->expectsJson()) {
            return $this->getPaymentsHistory($request, $school);
        }

        if ($subscription = $school?->subscription) {
            $subscription = json_decode(SubscriptionResource::make($subscription->load('plan'))->toJson());
        }

        return view('backend.admin.subscriptions.payments_history', compact('school', 'subscription'));
    }

    public function getSubscriptionStats(Request $request, $statsBy) {
        abort_if(!$request->expectsJson() || !in_array($statsBy, ['plans-subsribers']), 404);

        $plans = Plan::withCount('subscriptions')->get(['id', 'name']);

        $stats = [];

        foreach ($plans as $plan) {
            $stats['labels'][] = __($plan->name);
            $stats['data'][] = $plan->subscriptions_count;
        }

        return response()->json(['data' => $stats]);
    }

    public function show(SubscriptionPayment $subscriptionPayment) {
        abort_if(!request()->expectsJson(), 404);
        $subscriptionPayment->load(['payer', 'plan', 'receipt']);

        return new SubscriptionPaymentResource($subscriptionPayment);
    }

    public function doAction(Request $request,SubscriptionPayment $subscriptionPayment, $action) {
        abort_if(!in_array($action, ['confirm', 'cancel']) || $subscriptionPayment->status != $subscriptionPayment::IN_REVIEW, 403);

        $request->validate([
            'comment' => 'nullable|string'
        ]);

        if($action == 'confirm') $subscriptionPayment = $subscriptionPayment->complete($request->comment);
        else if($action == 'cancel') $subscriptionPayment = $subscriptionPayment->cancel($request->comment);

        $subscriptionPayment->load(['payer', 'plan', 'receipt']);
        return new SubscriptionPaymentResource($subscriptionPayment);
    }



    protected function getSubscriptions($request)
    {
        $subscriptions = PlanSubscription::with(['subscriber', 'plan'])->search($request->search)->latest()->when($request->get('without_pagination'), fn ($q) => $q->limit(5)->get(), fn ($q) => $q->latest()->paginate(15)->withQueryString());

        return SubscriptionResource::collection($subscriptions);
    }

    protected function getPaymentsHistory($request, $school)
    {
        $subscriptionPayments = ($school ? $school->subscription_payments() : SubscriptionPayment::query())->with(['plan', 'payer', 'receipt'])->latest()->when($request->get('without_pagination'), fn ($q) => $q->limit(5)->get(), fn ($q) => $q->latest()->paginate(15)->withQueryString());

        return SubscriptionPaymentResource::collection($subscriptionPayments);
    }
}
