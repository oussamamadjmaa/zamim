@extends('web.layouts.master', ['title' => __('Register')])

@section('content')
    <section class="login">
        <div class="auth-container">
            <div class="auth-content">
                <div class="container">
                    <div class="text-end pt-3 pt-md-5 pb-2">
                        <a href="{{ route('school.login') }}" class="link-blue fs-5">@lang('Login') <ion-icon
                                name="chevron-forward-outline"></ion-icon></a>
                    </div>

                    <div>
                        <div class="mw-756px ms-auto">
                            <register-form-component />
                        </div>
                    </div>

                    <div>
                        @include('web.layouts.partials.secondary-footer')
                    </div>
                </div>
            </div>
            <div class="login-page-bg"></div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .sample_app_menu_container ul {
            list-style-type: none;
            display: inline-flex;
            margin: 0px;
            padding: 0px;
        }

        .sample_app_menu_container ul li {
            font-size: 8pt;
            text-align: center;
            border-left: 1px solid lightgray;
            border-top: 1px solid lightgray;
            border-bottom: 1px solid lightgray;
            background-color: lightgray;
        }

        .sample_app_menu_container ul li:last-child {
            border-right: 1px solid lightgray;
        }

        .sample_app_menu_container ul li.logo {
            border: 0px;
            font-weight: bold;
            padding-top: 5px;
            padding-right: 10px;
            background-color: transparent;
        }

        .sample_app_menu_container ul li.logo a {
            color: black;
        }

        .sample_app_menu_container ul li.active {
            background-color: transparent;
            border-bottom: 0px;
        }

        .sample_app_menu_container ul li a {
            text-decoration: none;
            padding: 5px 10px;
            display: block;
            color: blue;
        }

        .aps_iframe {
            width: 550px;
            height: 450px;
            display: none;
        }

        .aps_modal {
            width: 550px;
            height: 450px;
            position: absolute;
            top: 20px;
            left: calc(50% - 275px);
            background-color: white;
            display: none;
        }

        .aps_3ds_iframe {
            width: 300px;
            height: 150px;
        }

        .aps_3ds_modal {
            width: 300px;
            height: 150px;
            position: absolute;
            top: 20px;
            left: calc(50% - 150px);
            background-color: white;
        }

        .hide {
            display: none;
        }

        .apple_pay_option {}

        .apple_pay_option.hide-me {
            /*display: none;*/
        }
    </style>
@endpush
