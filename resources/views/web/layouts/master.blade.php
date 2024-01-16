<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ config('app.direction') }}">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ isset($title) ? $title .' | ' : '' }} {{ config('app.name', 'منصة موجاتي') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap{{ config('app.direction') == 'rtl' ? '.rtl' : '' }}.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('web-assets/css/toast.css') }}">
    @vite(['resources/vue_web_assets/sass/style.scss', 'resources/vue_web_assets/js/app.js', 'resources/vue_web_assets/js/scripts.js'])
    @stack('styles')
  </head>
  <body class="{{ config('app.direction') }}">
    <div id="app">
        @yield('content')
    </div>

    <script>
        window._app = {
            url: '{{ url("/") }}',
        }
        window._locale = "{{ app()->getLocale() }}";
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @stack('scripts')
  </body>
</html>
