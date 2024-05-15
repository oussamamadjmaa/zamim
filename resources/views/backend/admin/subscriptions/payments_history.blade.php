@extends('backend.layouts.master', ['title' => __('Payments history')])
@section('content')
@if ($school)
    <a href="{{ route('admin.school.login_as', $school->id) }}" class="secondary-button my-4" target="_blank">تسجيل الدخول بإسم المدرسة</a>
    <h6 class="h7 mb-4">{{ trans('Subscription details for') }} {{ $school->name }}</h6>
    <div class="bg-white border rounded-16 py-4 px-4 h-100 col-lg-6 col-md-8 mb-4">
        <div class="d-flex flex-wrap justify-content-between">
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
        @else
        <div class="alert alert-danger">
            @lang('Not subscribed')
        </div>
        @endif
    </div>
@endif
    <subscription-payments-component :school='@json($school)'></subscription-payments-component>
@endsection
