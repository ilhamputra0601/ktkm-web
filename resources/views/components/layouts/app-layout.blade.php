<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="KTKM">
    <link rel="icon" href="{{ asset('images/default-logo.png') }}" type="image/icon type">
    <title>Karang&nbsp;Taruna&nbsp;Kemirimuka</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- header --}}
    <x-partials.Navbar/>

    <main>
        {{ $slot }}
    </main>

    {{-- footer --}}
    <x-partials.Footer/>
</body>
</html>
