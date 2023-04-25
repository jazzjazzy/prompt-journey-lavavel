<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" href="/favicon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/js/app.js','resources/css/app.css', 'resources/js/main.js'])
    @if (isset($isDashboardPage) && $isDashboardPage)
    @vite('resources/js/custom.js')
    @endif

    @if (env('APP_ENV') === 'production')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JX3V8TD36C"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-JX3V8TD36C');
    </script>
    @endif
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">

    <!-- Page Heading -->
    <header class="bg-white dark:bg-gray-800 shadow">
        @include('layouts.navigation')
    </header>
    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
    <footer class="fixed bottom-0 left-0 w-full p-4 pb-4 bg-white dark:bg-gray-800 shadow">
                <span class="m-0 p-0 text-xs text-gray-400">
                    <div data-url="{{route('tos')}}" title="Term of service" class="open-modal inline-block cursor-pointer" data-model-size="xl">Terms of Service</div>
                    | <div data-url="{{route('privacy')}}" title="Privacy Policy" class="open-modal inline-block cursor-pointer" data-model-size="xl">Privacy Policy</div>
                </span>
        <span class="float-right">
                <i class="fa fa-envelope"></i> <a href="mailto:jsjazzau@gmail.com" target="_blank">jsjazzau@gmail.com </a>
                </span>
    </footer>
</div>
<div id="myModal" class="modal hidden">
    <div class="overlay">
        <div class="card bg-gray-100 p-0 m-0">
            <div class="close p-0">
                <div class="bg-red-900 m-0 px-2 rounded-xl"><i class="text-sm fa-solid fa-xmark"></i></div>
            </div>
            <div class="w-full h-full flex flex-col">
                <div class="card-header">
                    <h1 id="modal-title" class="text-3xl">Active Modal</h1>
                </div>
                <div class="card-body flex-1 !mt-10 !p-0">
                    <iframe class="w-full h-full" id="modal-iframe"></iframe>
                </div>
                <div class="card-footer footer-right !mt-0 p-2">
                    <button class="close-btn btn btn-primary px-4 ml-2 mt-2 self-star">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
@yield('script')
