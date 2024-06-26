@extends('web.layouts.master', ['title' => __('Login')])

@section('content')
    <section class="login">
        <div class="auth-container">
            <div class="login-page-bg"></div>
            <div class="auth-content">
                <div class="container">

                    <div class="text-end pt-3 pt-md-5 pb-2">
                        @if ($routePrefix == 'school')
                        <a href="{{ route('web.home') }}" class="link-blue fs-5">@lang('Go Home') <ion-icon
                                name="chevron-forward-outline"></ion-icon></a>
                        @endif
                    </div>

                    <div class="mw-756px">
                        <div class="pb-3 mb-md-5 pb-md-4">
                            <h1 class="main-blue" data-aos="fade-up" data-aos-delay="300">@lang('Login')</h1>
                            <p data-aos="fade-up" data-aos-delay="400">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض
                                على العميل.</p>
                        </div>

                        <form class="auth-form-box" method="POST" action="{{ route($routePrefix.'.login') }}">
                            @csrf
                            <div class="form-input mb-3">
                                <label for="email" class="label_"><ion-icon name="person"></ion-icon></label>
                                <input type="email" class="input_ @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="@lang('Email Address')" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="button-main w-100">@lang('Continue')</button>
                        </form>
                        @if ($routePrefix == 'school')
                        <div class="text-center py-3">
                            @lang('Not registered yet on our platform?') <a href="{{ route($routePrefix.'.register') }}">@lang('Create an account')</a>
                        </div>
                        @endif
                    </div>

                    <div>
                        @include('web.layouts.partials.secondary-footer')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
