
@extends('web.layouts.master', ['title' => __('Page Expired')])

@section('content')
    @include('web.layouts.partials.header')

    <section class="error-page">
        <div class="col-md-8 mx-auto">
            <div class="error-page-content text-center py-5 my-4">
                <h5>@lang('Page Expired')</h5>

                <p class="mt-4">@lang('Oops! Please refresh the page or go back and try again')</p>

                <div class="mt-5">
                    <a href="{{ url()->previous() }}" class="button-main mb-2 me-md-3 me-2 py-1">@lang('Back')</a>
                </div>
            </div>
        </div>
    </section>

    @include('web.layouts.partials.footer')
@endsection
