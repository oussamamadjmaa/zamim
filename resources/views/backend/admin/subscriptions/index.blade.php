@extends('backend.layouts.master', ['title' => __('Subscriptions')])
@section('content')
    <div class="container">
        <subscriptions-component :withoutPagination="true"></subscriptions-component>
    </div>

    <div class="row mx-0 my-4">
        <div class="col-md-6 mb-4 mb-md-0">
            <subscription-payments-component :withoutPagination="true"></subscription-payments-component>
        </div>
        <div class="col-md-6">
            <subscriptions-stats-by-plan-component></subscriptions-stats-by-plan-component>
        </div>
    </div>
@endsection
