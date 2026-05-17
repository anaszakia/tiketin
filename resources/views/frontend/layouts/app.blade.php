<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TIKETIN - Beli Tiket Online Mudah & Cepat')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Base Styles --}}
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { overflow-x: hidden; }
    </style>

    {{-- Page Styles --}}
    @yield('styles')
</head>
<body>

    {{-- Header --}}
    @include('frontend.layouts.header')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.footer')

    {{-- Page Scripts --}}
    @yield('scripts')

</body>
</html>