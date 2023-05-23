<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Discover Prompt Journey, your go-to tool for creating unique and engaging prompts for mid-journey experiences. Join our creative community today!">
    <meta name="keywords" content="Prompt Journey, prompt creation tool, mid-journey prompts, creative writing, prompt generator, writing tool, creative inspiration">


    <title>Welcome to Prompt Journey: Your Compass for Creative Exploration</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>


    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/js/main.js'])


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


    {{ $slot }}


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
</div>

<script type="module">
    $(document).ready(function () {
        $('.popup-youtube').magnificPopup({
            type: 'iframe'
        });
    });
</script>

</body>
</html>
