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
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>

                        <form class="auth-form-box" method="POST" action="{{ route('portal.login.verify') }}">
                            @csrf
                            <div class="form-input mb-3">
                                <label for="code" class="label_"><ion-icon name="person"></ion-icon></label>
                                <input type="text" class="input_ @error('code') is-invalid @enderror @error('email') is-invalid @enderror" id="code"
                                    name="code" placeholder="@lang('Verification Code')" required>
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('email')
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
                            </div>

                            <button type="submit" class="button-main w-100">@lang('Login')</button>
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
