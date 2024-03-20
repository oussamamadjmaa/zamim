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
                    <form class="auth-form-box" method="POST" action="{{ route('school.password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-input mb-3">
                            <label for="email" class="label_"><ion-icon name="person"></ion-icon></label>
                            <input type="email" class="input_ @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="@lang('Email Address')" readonly value="{{ $email ?? old('email') }}" required>
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
                        <div class="form-input mb-3">
                            <label for="password_confirmation" class="label_"><ion-icon name="lock-open"></ion-icon></label>
                            <input type="password" class="input_ @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                name="password_confirmation" placeholder="@lang('Confirm Password')" required>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="button-main w-100">@lang('Reset Password')</button>
                    </form>
                </div>

                <div>
                    @include('web.layouts.partials.secondary-footer')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
