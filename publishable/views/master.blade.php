<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title', 'Mercurius Messenger')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/vendor/mercurius/favicon.ico') }}">

    <!-- CSS -->
    <link href="{{ asset('vendor/mercurius/css/mercurius.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('vendor/mercurius/js/mercurius.js') }}" defer></script>
    @yield('scripts', '')

    <!-- Global Object -->
    <script>
        window.Mercurius = {!! Mercurius::scriptVariables() !!};
    </script>
</head>
<body>
    @include('mercurius::inc.icons-svg')

    <div id="mercurius" class="mercurius" :class="{light: !darkMode}" v-cloak>
        @yield('content')
    </div>
</body>
</html>
