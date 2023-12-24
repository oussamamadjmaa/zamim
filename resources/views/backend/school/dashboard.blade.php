@extends('backend.layouts.master')
@section('content')
<div class="container">
    <!-- Dropdown Button -->
    <div class="dropdown">
        <h6 class="h9 dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            اليوم
        </h6>
        <p class="p5 text-gray mb-4">الأحد 2023.10.01</p>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#">آخر أسبوع</a></li>
            <li><a class="dropdown-item" href="#">آخر شهر</a></li>
            <li><a class="dropdown-item" href="#">آخر سنة</a></li>
        </ul>
    </div>

    <div class="row mx-0 stats-widgets mb-5">
        @foreach ($dashboardStats as $stat)
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-widget h-100 {{ $stat['bg-class'] }} p-4 rounded-16">
                <h6 class="h9 mb-5">{{ $stat['title'] }}</h6>
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="h7">{{ $stat['count'] }}</h6>
                    <p class="p4 mb-0">10%+ <ArrowRiseIcon /></p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
