<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('name', 'E-commerce') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 pb-10">

        <!-- Page Heading -->
        <header class="absolute top-0 left-0 w-full flex items-center z-10 transition duration-300 ease-in-out">
            @include('layouts.navigation')

            @if (isset($header))
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
            @endif
        </header>


        <!-- Page Content -->
        <main class="pt-20">
            {{ $slot }}
        </main>

        <!-- Toast -->
        <div
            x-data="toast"
            x-show="visible"
            x-transition
            x-cloak
            @notify.window="show($event.detail.message)"
            class="fixed w-[400px] left-1/2 -ml-[200px] top-16 py-2 px-4 pb-4 bg-emerald-500 text-white">
            <div class="font-semibold" x-text="message"></div>
            <button
                @click="close"
                class="absolute flex items-center justify-center right-2 top-2 w-[30px] h-[30px] rounded-full hover:bg-black/10 transition-colors">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <!-- Progress -->
            <div>
                <div
                    class="absolute left-0 bottom-0 right-0 h-[6px] bg-black/10"
                    :style="{'width': `${percent}%`}"></div>
            </div>
        </div>
        <!--/ Toast -->
    </div>

    <!-- Footer -->
    <footer class="pt-12 pb-12">
        <div class="container mx-auto px-4">
            <!-- Back To Top -->
            <div class="flex justify-center mb-8">
                <a href="#" class="flex items-center justify-center w-12 h-12 rounded-full bg-gray-700 hover:bg-gray-600">
                    <div class="text-white text-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 animate-fade-in-up">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                        </svg>
                    </div>
                </a>
            </div>
            <!-- Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h2 class="font-bold text-4xl mb-4">Toko Absurd</h2>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <div class="flex space-x-4 mt-5">
                        <a href="#" class=" hover:text-gray-300">
                            <span class="text-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-6 w-6"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                    <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <!-- Tautan -->
                <div class="font-medium">
                    <h2 class="font-semibold text-2xl mb-5">Tautan</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="group transition duration-300">
                                Home
                                <!-- Span untuk underline -->
                                <span class="block h-0.5 max-w-0 group-hover:max-w-12 transition-all duration-500 bg-sky-950"></span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group transition duration-300">
                                Shop
                                <span class="block h-0.5 max-w-0 group-hover:max-w-11 transition-all duration-500 bg-sky-950"></span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group transition duration-300">
                                About
                                <span class="block h-0.5 max-w-0 group-hover:max-w-12 transition-all duration-500 bg-sky-950"></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="font-medium">
                    <h2 class="text-2xl font-semibold mb-4">Hubungi Kami</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <span class="text-2xl mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="h-6 w-6"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                    <path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                                </svg>
                            </span>
                            <span class="">Jl. Gading Indah 847, Surabaya, Jawa Timur</span>
                        </li>
                        <li class="flex items-center">
                            <a href="#" class="flex items-center  hover:text-gray-300">
                                <span class="text-2xl mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-6 w-6"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                        <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
                                    </svg>
                                </span>
                                <span>0818181818</span>
                            </a>
                        </li>
                        <li class="flex items-center">
                            <a href="#" class="flex items-center  hover:text-gray-300">
                                <span class="text-2xl mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-6 w-6"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                        <path d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z" />
                                    </svg>
                                </span>
                                <span>tokoabsurd@example.com</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>