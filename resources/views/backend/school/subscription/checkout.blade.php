@extends('backend.layouts.master', ['title' => __('Subscription')])

@section('content')
<div class="bg-white p-3 rounded-16 border col-md-10 mx-auto">
    @if ($errors->any())
        <ul class="alert alert-danger list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <h1 class="text-center py-5">@lang('Choose payment method')</h1>

    <form method="post" action="{{ route('school.subscription.checkout') }}" >
        @csrf
        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
        <div class="d-flex justify-content-center">
            @foreach (config('payment-methods') as $paymentMethod)
            <div class="form-check payment-method">
                <input class="d-none" type="radio" name="payment_method" id="{{ $paymentMethod['key'] }}" value="{{ $paymentMethod['key'] }}" @checked($paymentMethod['is_default'] ?? false) />
                <label class="form-check-label" for="{{ $paymentMethod['key'] }}"> <img src="{{ $paymentMethod['logo'] }}" alt=""> </label>
            </div>
            @endforeach
        </div>

        <div class="text-center py-5">
            <button class="primary-button py-3 fs-5" type="submit" style="min-width: 270px;">@lang('Continue')</button>
        </div>
    </form>
</div>
@endsection
