<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">


    <title>Event Manager</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <link rel="icon" type="image/svg+xml" href="{{ Vite::asset('resources/images/logo-white.svg') }}">




    @vite(['resources/css/app.css'])


    @vite(['resources/js/calendar/store.js'])
    @vite(['resources/js/app.js'])

    @stack('head')

</head>
<body class="text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-900" x-data="{}">
    <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 300)" x-show="loading" class="fixed inset-0 bg-gray-100 dark:bg-gray-900 flex items-center justify-center z-50"
      x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 "
         x-transition:leave-end="opacity-0 "
    >

        <div class="loader"></div>

    </div>
 

    @include('main.includes.header')

    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="w-full  lg:flex-row">
            @yield('body')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
