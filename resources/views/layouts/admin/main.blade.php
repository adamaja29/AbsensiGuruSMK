<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('tabler/css/tabler.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>

<div class="page">
    @include('layouts.admin.sidebar')
    <div class="page-wrapper">
        @include('layouts.admin.header')
        <div class="page-body">
            @yield('content')
        </div>
    </div>
</div>

<script src="{{ asset('tabler/js/tabler.min.js') }}"></script>
</body>
</html>