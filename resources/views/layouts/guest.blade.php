<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
<body class="font-sans text-gray-900 antialiased">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <div>
        <a href="/">
            <x-application-logo class="w-36 h-36 fill-current text-gray-500"/>
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-1 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('.popup-youtube').magnificPopup({
            type: 'iframe'
        });
    });
</script>

</body>
</html>
