<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @stack('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body class="font-sans antialiased" x-data="sidebar()" @resize.window="sideResize()">
    <x-notifications z-index="z-50" />
    <x-dialog z-index="z-50" blur="md" align="center" />
    <div class="flex h-screen">
        <main class="w-full m-auto md:w-1/3 ">
            {{ $slot }}
        </main>
    </div>


    @livewireScripts
    @wireUiScripts
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')

</body>

</html>
