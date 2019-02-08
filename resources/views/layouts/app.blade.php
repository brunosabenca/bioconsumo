<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script charset="utf-8">
        window.App = {!! json_encode([
            'user' => auth()->user(),
            'userPermissions' => optional(auth()->user())->all_permissions,
            'signedIn' => auth()->check(),
            'isAdmin' => optional(auth()->user())->hasRole('admin') ?? false,
        ]) !!};
    </script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    @yield('head')
</head>
<body>
@include('layouts.nav')

<main id="app" class="bd-content px-4 pt-5" role="main">
    <div class="my-5">@yield('content')</div>
    <flash message="{{ session('flash-message') }}" level="{{ session('flash-level') ? session('flash-level') : 'success'}}"></flash>
</main><!-- /.container -->


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<script>
    $( document ).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'top',
            trigger : 'hover'
        });

        $('[data-toggle="tooltip"]').on('click', function () {
            $(this).tooltip('hide')
        })
    });


    @yield('scripts')
</script>
</body>
</html>