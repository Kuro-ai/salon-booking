<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mingalar</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
</head>
<body class="font-sans antialiased bg-gradient-to-r from-teal-400 via-pink-500 to-purple-700 text-white">

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center">
        <div class="bg-black bg-opacity-60 w-full max-w-4xl p-8 rounded-xl shadow-2xl">
            <div class="text-center">
                <div class="flex lg:justify-center lg:col-start-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 -960 960 960"><defs>
                        <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#00d1b2;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#ff7f50;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#gradient1)" d="M200-80 40-520l200-120v-240h160v240l200 120L440-80zm480 0q-17 0-28.5-11.5T640-120t11.5-28.5T680-160h120v-80H680q-17 0-28.5-11.5T640-280t11.5-28.5T680-320h120v-80H680q-17 0-28.5-11.5T640-440t11.5-28.5T680-480h120v-80H680q-17 0-28.5-11.5T640-600t11.5-28.5T680-640h120v-80H680q-17 0-28.5-11.5T640-760t11.5-28.5T680-800h160q33 0 56.5 23.5T920-720v560q0 33-23.5 56.5T840-80zm-424-80h128l118-326-124-74H262l-124 74zm64-200"/></svg>
                    
                </div>
                <h1 class="text-4xl font-semibold text-gray-100 mb-6">Welcome to Marina Nail Art & Spa</h1>
                <p class="text-lg text-gray-200 mb-8">Where beauty and self-care come together to help you look and feel your best!</p>
                <p class="text-lg text-gray-300 mb-8">Join us now and get started!</p>

                <div class="flex justify-center space-x-6">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-6 py-3 text-lg bg-teal-600 text-white rounded-md shadow-md transition-all duration-300 hover:bg-teal-500">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-6 py-3 text-lg bg-teal-600 text-white rounded-md shadow-md transition-all duration-300 hover:bg-teal-500">
                            Log In
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-6 py-3 text-lg bg-transparent border-2 border-white text-white rounded-md shadow-md transition-all duration-300 hover:bg-white hover:text-teal-600">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

</body>
</html>
