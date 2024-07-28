<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css.map') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    @yield('style')
</head>

<body>
    @yield('content')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js.map') }}"></script>
    <script src="{{ asset('assets/js/all.min.js') }}"></script>
    @yield('script')
</body>

</html>
