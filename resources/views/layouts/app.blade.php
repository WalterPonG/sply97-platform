<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-white bg-black overflow-x-hidden">

    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-[url('/images/coc_bg.jpg')] bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-black/70"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col">

        @include('layouts.navigation')

        <main class="flex-1 max-w-6xl mx-auto w-full px-4 py-6">
            {{ $slot }}
        </main>

    </div>

</body>
</html>
