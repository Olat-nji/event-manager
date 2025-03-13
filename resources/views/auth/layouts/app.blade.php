<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EVM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <link rel="icon" type="image/svg+xml" href="{{ Vite::asset('resources/images/logo-white.svg') }}">

    <!-- Styles / Scripts -->
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-gray-900 dark:text-white flex gap-2 p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="w-full py-4 flex justify-center sm:justify-between flex-wrap gap-4">
        <span>
            <img class="h-5 w-auto" src="{{Vite::asset('resources/images/logo-white.svg')}}" alt="EVM">
        </span>
        @yield('redirect')

    </div>
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0 my-auto">
        <main class="flex max-w-[400px] w-full flex-col-reverse lg:flex-row">
            @yield('body')
        </main>
    </div>


</body>
</html>
