<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ config('app.direction') }}">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title .' | ' : '' }} {{ config('app.name', 'منصة موجاتي') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap{{ config('app.direction') == 'rtl' ? '.rtl' : '' }}.min.css">
    <link href="//glenthemes.github.io/iconsax/style.css" rel="stylesheet">

    <link href="{{ asset('vendor/hijri-date-picker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web-assets/css/toast.css') }}">

    @vite(array_merge(['resources/vue_backend_assets/sass/style.scss'], $viteIncludes ?? []))
    @stack('styles')
  </head>
  <body @class([config('app.direction'), 'has-radios-sidebar' => $routePrefix == 'admin__'])>

    <div id="app">
        @include('backend.layouts.partials.sidebar')

        @include('backend.layouts.partials.navbar')

        <main>
            <div class="wrapper py-3 p-md-2 p-lg-3">
                @yield('content')
            </div>
        </main>

        @includeWhen($routePrefix == 'admin__','backend.layouts.partials.radios-sidebar')
    </div>

    <script>
        window._app = {
            url: '{{ url("/") }}',
            notificationsRoute: "{{ route($routePrefix.'.notifications.stats') }}",
            notificationUrl: "{{ route($routePrefix.'.notifications.redirect', 'notificationId') }}",
            currentSemester: {!! json_encode($currentSemester) !!}
        }
        window._locale = "{{ app()->getLocale() }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="//glenthemes.github.io/iconsax/geticons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://moment.github.io/luxon/global/luxon.min.js"></script>
    <script src="{{ asset('vendor/hijri-date-picker/js/bootstrap-hijri-datetimepicker.min.js') }}"></script>
    @stack('scripts')
  </body>
</html>
