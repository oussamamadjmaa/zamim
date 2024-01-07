@extends('backend.layouts.master', ['title' => __('Profile')])

@section('content')
<div class="container">
    <div class="row mx-0 justify-content-between py-5">
        <div class="col-lg-4 col-md-5 mb-4 mb-md-0">
            <div class="bg-white border rounded-16 p-4 h-100">
                <div class="user-avatar">
                    <div class="user-avatar-holder">
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}">
                    </div>
                </div>
                <div class="user-information text-center pt-3">
                    <h6 class="h9">{{ auth()->user()->name }}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-7">
            <div class="bg-white border rounded-16 p-4 h-100">
                <h6 class="h7">@lang('Personal information')</h6>
                <p>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل .</p>

                <form action="#" method="POST" class="my-4">
                    @csrf
                    @method('PUT')
                    <div class="form-input mb-3">
                        <label for="email" class="label_"><ion-icon name="person"></ion-icon></label>
                        <input type="email" class="input_ @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="@lang('Email Address')" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button class="button button-orange py-3 px-4">@lang('Save changes')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
