@extends('backend.layouts.master', ['title' => __('Subscription')])

@section('content')
    <div class="container">
        <div class="bg-white border rounded-16 py-4 px-4 h-100 col-lg-6 col-md-8 mb-4">
            <div class="d-flex flex-wrap justify-content-between mb-3">
                <h6 class="h7">{{ trans('Current subscription') }}</h6>
            </div>

            @if ($subscription)
            <div class="d-flex justify-content-between">
                <div>
                    <p class="p5 mb-1 text-secondary">@lang('Subscription plan')</p>
                    <h6 class="h9">{{ $subscription->plan->name }}</h6>
                </div>
                <div>
                    <p class="p5 mb-1 text-secondary">@lang('Subscription status')</p>
                    <span class="badge bg-{{ $subscription->status }}">{{ $subscription->statusText }}</span>
                </div>
                <div>
                    <p class="p5 mb-1 text-secondary">@lang('Subscription ends at')</p>
                    <h6 class="h9">{{ $subscription->endsAt }}</h6>
                </div>
            </div>
            <div class="pt-4">
                @if ($canRenew)
                    <a href="{{ route('school.subscription.checkout') }}" class="primary-button me-2">@lang('Renew subscription')</a>
                @endif

                @if ($canChangePlan)
                    <a href="{{ route('school.subscription.choose-plan') }}" class="primary-button">@lang('Change subscription plan')</a>
                @endif
            </div>
            @else
            <div class="alert alert-danger">
                @lang('Not subscribed')
                @if (!$paymentOnHold)
                    <a href="{{ route('school.subscription.choose-plan') }}" style="color: blue;">@lang('Subscribe now')</a>
                @endif
            </div>
            @endif
        </div>
        <subscription-payments-component></subscription-payments-component>
    </div>
@endsection
