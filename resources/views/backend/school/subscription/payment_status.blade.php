@extends('backend.layouts.master', ['title' => __('Subscription')])

@section('content')
    <div class="container">
        <div class="bg-white border rounded-16 py-4 px-4 h-100 col-lg-6 col-md-8 mx-auto mb-4">
            <div class="text-center">
                @if ($subscriptionPayment->isCompleted())
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" fill="#28a745" width="91"><path d="M256 48C141.31 48 48 141.31 48 256s93.31 208 208 208 208-93.31 208-208S370.69 48 256 48zm108.25 138.29l-134.4 160a16 16 0 01-12 5.71h-.27a16 16 0 01-11.89-5.3l-57.6-64a16 16 0 1123.78-21.4l45.29 50.32 122.59-145.91a16 16 0 0124.5 20.58z"/></svg>
                <h3 class="my-3">@lang('Payment Success')</h3>
                <p class="text-secondary">@lang('Congrats, your payment #:id has been confirmed, thank you!', ['id' => $subscriptionPayment->id])</p>

                <a href="{{ route('school.dashboard') }}" class="primary-button me-2">@lang('Dashboard')</a>
                @elseif ($subscriptionPayment->isOnHold())
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" fill="#ffc107" width="91">
                    <path d="M256 48C141.31 48 48 141.31 48 256s93.31 208 208 208 208-93.31 208-208S370.69 48 256 48zm0 319.91a20 20 0 1120-20 20 20 0 01-20 20zm21.72-201.15l-5.74 122a16 16 0 01-32 0l-5.74-121.94v-.05a21.74 21.74 0 1143.44 0z"/>
                </svg>

                <h3 class="my-3">@lang('Payment on hold')</h3>
                <p class="text-secondary">@lang('Your payment #:id is on hold, we will let you know when it is confirmed!', ['id' => $subscriptionPayment->id])</p>
                @elseif ($subscriptionPayment->isOnReview())
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" fill="#007bff" width="91">
                    <path d="M256 48C141.31 48 48 141.31 48 256s93.31 208 208 208 208-93.31 208-208S370.69 48 256 48zm0 319.91a20 20 0 1120-20 20 20 0 01-20 20zm21.72-201.15l-5.74 122a16 16 0 01-32 0l-5.74-121.94v-.05a21.74 21.74 0 1143.44 0z"/>
                </svg>

                <h3 class="my-3">@lang('Payment in review')</h3>
                <p class="text-secondary">@lang('Your payment #:id is in review, we will let you know when it is confirmed!', ['id' => $subscriptionPayment->id])</p>
                @elseif ($subscriptionPayment->isFailed())
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" fill="#dc3545" width="91"><path d="M256 48C141.31 48 48 141.31 48 256s93.31 208 208 208 208-93.31 208-208S370.69 48 256 48zm75.31 260.69a16 16 0 11-22.62 22.62L256 278.63l-52.69 52.68a16 16 0 01-22.62-22.62L233.37 256l-52.68-52.69a16 16 0 0122.62-22.62L256 233.37l52.69-52.68a16 16 0 0122.62 22.62L278.63 256z"/></svg>

                <h3 class="my-3">@lang('Payment Failed')</h3>
                <p class="text-secondary">@lang('Sorry, your payment #:id has been failed due the the following reason:', ['id' => $subscriptionPayment->id]) {{ session('payment_response_message') }}</p>
                @endif
                <a href="{{ route('school.subscription.index') }}" class="secondary-button">@lang('Payment history')</a>
            </div>
        </div>
    </div>
@endsection
