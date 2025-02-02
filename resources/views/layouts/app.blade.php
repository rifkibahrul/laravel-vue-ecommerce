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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-primary">
    <!-- Page Heading -->
    <!-- <header class="absolute top-0 left-0 w-full flex items-center z-10 transition duration-300 ease-in-out"> -->
    <header class="sticky top-0 shadow-xl z-30 bg-white">
        @include('layouts.navigation')

        @if (isset($header))
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
        @endif
    </header>


    <!-- Page Content -->
    <!-- <main class="pt-20"> -->
    <main class="max-w-[1920px] mx-auto overflow-hidden">
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

    <!-- Footer -->
    <footer class="footer mt-[80px] xl:mt-[120px] relative z-20 min-h-fit border-t-2">
        <div class="container mx-auto px-0">
            <div class="flex flex-col xl:flex-row xl:gap-[100px] mb-[64px] xl:mb-[100px] mt-[60px]">
                <div class="footer__item w-full max-w-[400px] mx-auto mb-8 text-center xl:text-left">
                    <!-- Logo -->
                    <a class="flex justify-center xl:justify-start mb-8" href="">
                        <img src="{{ asset('assets/images/Logo.svg') }}" alt="">
                    </a>
                    <p class="mb-8 text-xl">
                        Experience the best online shopping with us!
                    </p>
                    <!-- Socials -->
                    <ul class="flex gap-[54px] justify-center xl:justify-start">
                        <li>
                            <a class="hover:text-secondary" href=""><i class="ri-instagram-fill text-2xl"></i></a>
                        </li>
                        <li>
                            <a class="hover:text-secondary" href=""><i class="ri-twitter-fill text-2xl"></i></a>
                        </li>
                        <li>
                            <a class="hover:text-secondary" href=""><i class="ri-linkedin-fill text-2xl"></i></a>
                        </li>
                        <li>
                            <a class="hover:text-secondary" href=""><i class="ri-facebook-fill text-2xl"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="flex-1 flex flex-col xl:flex-row text-center xl:text-left gap-12 xl:gap-[100px] xl:justify-end">
                    <div class="footer__item">
                        <h3 class="text-[25px] mb-3 font-bold">Page</h3>
                        <ul class="flex flex-col gap-4 text-[15px]">
                            <li>
                                <a class="hover:text-secondary" href="">Home</a>
                            </li>
                            <li>
                                <a class="hover:text-secondary" href="">Shop</a>
                            </li>
                            <li>
                                <a class="hover:text-secondary" href="">About</a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer__item">
                        <h3 class="text-[25px] mb-3 font-bold">Service</h3>
                        <ul class="flex flex-col gap-4 text-[15px]">
                            <li>
                                <P>Fast Delivery</P>
                            </li>
                            <li>
                                <P>24/7 Support</P>
                            </li>
                            <li>
                                <P>Guaranteed Quality</P>
                            </li>
                            <li>
                                <P>Affordable Price</P>
                            </li>
                        </ul>
                    </div>
                    <div class="footer__item max-w-[260px] mx-auto xl:mx-0">
                        <h3 class="text-[25px] mb-3 font-bold">Have a Questions?</h3>
                        <div class="flex flex-col gap-6 text-[18px]">
                            <p>Jl. Gading Indah 847, Surabaya, Jawa Timur</p>
                            <p>contact@inflame.com</p>
                            <p>(1234) 567890</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="bg-neutral-200 p-5">
        </div> -->

        <!-- Copyright -->
        <p class="footer__copyright text-center text-lg py-10 border-t-2">Copyright &copy; inflame 2024. All rights reserved.</p>
    </footer>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scroll reveal JS -->
    <script src="{{ asset('assets/js/scrollreveal.min.js') }}"></script>

    <!-- Swiper reveal JS -->
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>