
@extends('web.layouts.master', ['title' => __('Page Not Found')])

@section('content')
    @include('web.layouts.partials.header')

    <section class="error-page">
        <div class="col-md-8 mx-auto">
            <div class="error-page-content text-center py-5 my-4">
                <h1>404</h1>

                <p>
                    <p>@lang('Oops! The page you are looking for doesn\'t exist')</p>
                </p>
            </div>
        </div>
    </section>

    @include('web.layouts.partials.footer')
@endsection
