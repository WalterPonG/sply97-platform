<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-950">

	@if(session('level_up'))
	<script>
	document.addEventListener('DOMContentLoaded', () => {
    		addFeed('LEVEL UP! 🎉', 'level');
	});
	</script>
	@endif

	<div id="rewardPopup"
     		class="fixed bottom-6 right-6 bg-gray-900 text-white p-4 rounded-xl shadow-lg hidden">
	</div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="max-w-7x1 mx-auto px-6 py-8">
                {{ $slot }}
            </main>
        </div>

	<div id="eventFeed"
     		class="fixed top-4 right-4 w-64 space-y-2 z-50">
	</div>

</body>
</html>
