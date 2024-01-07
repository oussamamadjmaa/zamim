@extends('backend.layouts.master', ['title' => __('Statistics')])
@section('content')
    <div class="row mx-0 my-4">
        <div class="col-md-6 mb-4">
            <chartjs-component stats_url="{{ route('admin.stats', ['radios', 'periodValue']) }}" title="@lang('Radios')"></chartjs-component>
        </div>
        <div class="col-md-6 mb-4">
            <chartjs-component stats_url="{{ route('admin.stats', ['visits', 'periodValue']) }}" type="line" version="2" title="@lang('Website Visits')"></chartjs-component>
        </div>
        <div class="col-md-6 mb-4">
            {{-- <chartjs-component stats_url="{{ route('admin.stats', ['radios', 'periodValue']) }}" title="@lang('Radios')"></chartjs-component> --}}
        </div>
    </div>
@endsection
