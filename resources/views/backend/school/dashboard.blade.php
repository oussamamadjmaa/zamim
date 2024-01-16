@extends('backend.layouts.master', ['title' => __('Dashboard')])
@section('content')
<div class="container">
    <div class="dropdown">
        <h6 class="h9 dropdown-toggle mb-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
            aria-expanded="false">
            @lang($periods[$period])
        </h6>
        <p class="p5 text-gray mb-4">{{ $hijriDateRanges[0] }} {{ $hijriDateRanges[0] != $hijriDateRanges[1] ? ' - ' .$hijriDateRanges[1] : '' }}</p>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @foreach ($periods as $periodVal => $periodText)
                <li><a class="dropdown-item" href="{{ route('school.dashboard', ['period' => $periodVal]) }}">{{ $periodText }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="row mx-0 stats-widgets mb-5">
        @foreach ($dashboardStats as $stat)
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{$stat['link']}}" class="stat-widget d-block h-100 {{ $stat['bg-class'] }} p-4 rounded-16">
                <h6 class="h9 mb-5">{{ $stat['title'] }}</h6>
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="h7">{{ $stat['count'] }}</h6>
                </div>
            </a>
        </div>
        @endforeach
    </div>


    <div class="row mx-0">
        <div class="col-md-6 mb-4 mb-md-0">
            <chartjs-component stats_url="{{ route('school.stats', ['students', 'periodValue']) }}" title="@lang('Students number')"></chartjs-component>
        </div>
        <div class="col-md-6">
            <chartjs-component stats_url="{{ route('school.stats', ['teachers', 'periodValue']) }}" title="@lang('Teachers number')"></chartjs-component>
        </div>
    </div>
</div>
@endsection
