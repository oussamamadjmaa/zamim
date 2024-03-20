@extends('web.layouts.master', ['title' => __('Login')])

@section('content')
    <section class="login">
        <div class="auth-container">
            <div class="login-page-bg"></div>
            <div class="auth-content">
                <div class="container justify-content-center">
                    <div class="mw-756px">
                        <div class="pb-3 mb-md-5 pb-md-4">
                            <h1 class="main-blue" data-aos="fade-up" data-aos-delay="300">@lang('Login')</h1>
                        </div>

                        <form class="auth-form-box" method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="form-input mb-3">
                                <label for="username" class="label_"><ion-icon name="person"></ion-icon></label>
                                <input type="text" class="input_ @error('username') is-invalid @enderror" id="username" name="username"
                                    placeholder="@lang('Username')" value="{{ old('username') }}">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-input mb-3">
                                <label for="password" class="label_"><ion-icon name="lock-open"></ion-icon></label>
                                <input type="password" class="input_ @error('password') is-invalid @enderror" id="password" name="password" placeholder="@lang('Password')">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex flex-wrap justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        @lang('Remember Me')
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="button-main w-100">@lang('Login')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
