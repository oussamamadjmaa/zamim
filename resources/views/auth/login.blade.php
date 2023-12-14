@extends('web.layouts.master', ['title' => __('Login')])

@section('content')
    <section class="login">
        <div class="auth-container">
            <div class="login-page-bg"></div>
            <div class="auth-content">
                <div class="container">
                    <div class="text-end pt-3 pt-md-5 pb-2">
                        <a href="{{ route('web.home') }}" class="link-blue fs-5">@lang('Go Home') <ion-icon
                                name="chevron-forward-outline"></ion-icon></a>
                    </div>

                    <div class="mw-756px">
                        <div class="pb-3 mb-md-5 pb-md-4">
                            <h1 class="main-blue" data-aos="fade-up" data-aos-delay="300">@lang('Login')</h1>
                            <p data-aos="fade-up" data-aos-delay="400">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض
                                على العميل.</p>
                        </div>

                        <form class="auth-form-box" method="POST" action="{{ route('school.login') }}">
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
                            <div class="form-input mb-3">
                                <label for="password" class="label_"><ion-icon name="lock-open"></ion-icon></label>
                                <input type="password" class="input_ @error('password') is-invalid @enderror" id="password"
                                    name="password" placeholder="@lang('Password')" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="d-flex flex-wrap justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        @lang('Remember Me')
                                    </label>
                                </div>

                                <a href="{{ route('school.password.request') }}">@lang('Forgot Your Password?')</a>
                            </div>

                            <button type="submit" class="button-main w-100">@lang('Login')</button>
                        </form>

                        <div class="text-center py-3">
                            @lang('Not registered yet on our platform?') <a href="{{ route('school.register') }}">@lang('Create an account')</a>
                        </div>
                    </div>

                    <div>
                        @include('web.layouts.partials.secondary-footer')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
