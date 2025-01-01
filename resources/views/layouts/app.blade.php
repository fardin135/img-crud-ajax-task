<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title' , 'Job Task')</title>
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
</head>
<body>
@include('layouts.navbar')

    @yield('main')

{{-- bootstrap js --}}
    <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
{{-- ajax jquery --}}
    <script src="{{ asset('ajax/jquery.js') }}" ></script>
    {{-- custom ajax --}}
    <script src="{{ asset('ajax/ajaxCustom.js') }}" ></script>

    @stack('scripts')
</body>
</html>
