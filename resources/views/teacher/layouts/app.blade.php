<?php
use Illuminate\Support\Facades\URL;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('pageTitle')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css.map') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('pageStyle')
</head>

<body>
    <div class="layout-wrapper">
        <div class="layout-container">
            @include('teacher.layouts.sidebar')
            <div class="layout-page">
                <div class="blur-box"></div>
                @include('teacher.layouts.navbar')
                <div class="content-wrapper">
                    <button onclick="goBack()" class="back-arrow position-fixed"><i
                            class="fa-solid fa-arrow-left"></i></button>
                    <div class="page-content">
                        @yield('content')
                    </div>
                    @include('teacher.layouts.footer')
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js.map') }}"></script>
    <script src="{{ asset('assets/js/all.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @yield('pageScript')

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>
