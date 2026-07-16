<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'PCB Dimension Calculator')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    @yield('content')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @stack('scripts')

</body>

</html>