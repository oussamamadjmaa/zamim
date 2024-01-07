@extends('web.layouts.master', ['title' => 'تأكيد تسجيل الدخول'])

@section('content')
    <section class="login">
        <div class="auth-container">
            <div class="login-page-bg"></div>
            <div class="auth-content">
                <div class="container justify-content-center">
                    <div class="mw-756px">
                        <div class="pb-3 mb-md-5 pb-md-4">
                            <h1 class="main-blue" data-aos="fade-up" data-aos-delay="300">@lang('Login')</h1>
                            <p data-aos="fade-up" data-aos-delay="300">{{ $school->name }}</p>
                        </div>

                        <form class="auth-form-box" method="POST" action="{{ route('admin.school.login_as', $school->id) }}">
                            @csrf
                            <div class="form-input mb-3">
                                <label for="password" class="label_"><ion-icon name="lock-open"></ion-icon></label>
                                <input type="password" class="input_ @error('password') is-invalid @enderror" id="password" name="password" placeholder="@lang('Password')">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="button-main w-100">@lang('Continue')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
