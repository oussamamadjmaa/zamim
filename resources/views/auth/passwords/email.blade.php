@extends('web.layouts.master', ['title' => __('Reset Password')])

@section('content')
    <section class="login">
        <div class="auth-container">
            <div class="login-page-bg"></div>
            <div class="auth-content">
                <div class="container">
                    <div class="text-end pt-3 pt-md-5 pb-2">
                        <a href="{{ route('school.login') }}" class="link-blue fs-5">@lang('Login') <ion-icon
                                name="chevron-forward-outline"></ion-icon></a>
                    </div>

                    <div class="mw-756px">
                        <div class="pb-3 mb-md-5 pb-md-4">
                            <h1 class="main-blue" data-aos="fade-up" data-aos-delay="300">@lang('Reset Password')</h1>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="auth-form-box" method="POST" action="{{ route('school.password.email') }}">
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
                            <button type="submit" class="button-main w-100">@lang('Send Password Reset Link')</button>
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
