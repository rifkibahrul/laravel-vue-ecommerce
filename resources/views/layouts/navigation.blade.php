<nav
    x-data="{ 
            open: false, 
            mobileMenuOpen: false, 
            cartItemsCount: {{ \App\Helpers\Cart::getCartItemsCount() }}, isScrolled: false}"
    @cart-change.window="cartItemsCount = $event.detail.count">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <!-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" /> -->
                        <img src="{{ asset('assets/images/Logo.svg') }}" alt="logo" class="block h-14 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 lg:-my-px lg:ms-10 lg:flex ">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="hover:text-secondary transition duration-300">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('product')" :active="request()->routeIs('product')" class="hover:text-secondary transition duration-300">
                        {{ __('Product') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden lg:flex lg:items-center lg:ms-6">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative inline-flex items-center py-2 px-3 hover:bg-slate-700 hover:text-stone-300 transition-all before:ease-out before:duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Cart
                    <small x-show="cartItemsCount" x-transition x-cloak x-text="cartItemsCount" class="ml-1 py-[2px] px-[8px] rounded-full bg-red-500"></small>
                </a>
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-md text-gray-500 dark:text-gray-400  dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div class="bg-white rounded-full p-[5px] flex justify-center items-center">
                                <img src="{{ asset('assets/svgs/avatar.svg') }}" class="size-[35px] rounded-full mr-3" alt="">{{ Auth::user()->name }}
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('order.index')" :active="request()->routeIs('order.*')" class="hover:text-secondary transition duration-300">
                            <img src="{{ asset('assets/svgs/ic-note.svg') }}" alt="order" class="mr-2 w-5 h-5">{{ __('My Orders') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="hover:text-secondary transition duration-300">
                            <img src="{{ asset('assets/svgs/ic-profile.svg') }}" alt="profile" class="mr-2 w-5 h-5">{{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <!-- Logout Section -->
                            <x-dropdown-link :href="route('logout')" class="hover:text-secondary transition duration-300"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                <img src="{{ asset('assets/svgs/logout.svg') }}" alt="" class="mr-2 w-5 h-5">{{ __('Log Out') }}
                            </x-dropdown-link>

                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <!-- <a href="{{ route('login') }}" class="relative inline-flex items-center justify-center overflow-hidden shadow-2xl transition-all before:absolute before:h-0 before:w-0 before:rounded-full before:bg-slate-700 before:duration-500 before:ease-out hover:shadow-slate-700 border border-slate-700 py-2 px-4 rounded hover:text-white hover:before:h-56 hover:before:w-56 ml-2">
                    <span class="relative z-10">Log In</span>
                </a> -->
                <a href="{{ route('login') }}" class="bg-slate-700 text-white relative inline-flex items-center justify-center overflow-hidden shadow-2xl transition-all before:absolute before:h-0 before:w-0 before:rounded-full before:bg-white before:duration-500 before:ease-out hover:shadow-slate-700 border border-slate-700 py-2 px-4 rounded-xl hover:text-black hover:before:h-56 hover:before:w-56 ml-2">
                    <span class="relative z-10">Login</span>
                </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center lg:hidden">
                <button @click="open =! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex':! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden':! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu Mobile Screen-->
    <div :class="{'block': open, 'hidden':! open}" class="hidden lg:hidden">

        <!-- Responsive Main Navigation Menu -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="relative inline-flex items-center py-2 px-3 hover:text-secondary transition duration-300">
                <img src="{{ asset('assets/svgs/home.svg') }}" alt="home" class="mr-2 w-5 h-5">{{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('product')" :active="request()->routeIs('product')" class="relative inline-flex items-center py-2 px-3 hover:text-secondary transition duration-300">
                <img src="{{ asset('assets/svgs/ic-shopping-bag.svg') }}" alt="product" class="mr-2 w-5 h-5">{{ __('Product') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="relative inline-flex items-center py-2 px-3 hover:bg-slate-700 hover:text-stone-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Cart
                <small x-show="cartItemsCount" x-transition x-cloak x-text="cartItemsCount" class="ml-1 py-[2px] px-[8px] rounded-full bg-red-500"></small>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="py-4 border-t border-gray-200 dark:border-gray-600">
            @auth
            <div class="px-4">
                <img src="{{ asset('assets/svgs/avatar.svg') }}" class="size-[35px] rounded-full mb-2" alt="">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('order.index')" :active="request()->routeIs('order.*')" class="flex items-center ">
                    <img src="{{ asset('assets/svgs/ic-note.svg') }}" alt="order" class="mr-2 w-5 h-5">{{ __('My Orders') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="flex items-center">
                    <img src="{{ asset('assets/svgs/ic-profile.svg') }}" alt="profile" class="mr-2 w-5 h-5">{{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" class="flex items-center"
                        onclick="event.preventDefault();
                                            this.closest('form').submit();">
                        <img src="{{ asset('assets/svgs/logout.svg') }}" alt="" class="mr-2 w-5 h-5">{{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @else
            <a href="{{ route('login') }}" class="relative inline-flex items-center justify-center overflow-hidden shadow-2xl transition-all before:absolute before:h-0 before:w-0 before:rounded-full before:bg-slate-700 before:duration-500 before:ease-out hover:shadow-slate-700 border border-slate-700 py-2 px-4 rounded-xl hover:text-white hover:before:h-56 hover:before:w-56 ml-5 md:ml-2">
                <span class="relative z-10">Login</span>
            </a>
            <a href="{{ route('register') }}" class="bg-slate-700 text-white relative inline-flex items-center justify-center overflow-hidden shadow-2xl transition-all before:absolute before:h-0 before:w-0 before:rounded-full before:bg-white before:duration-500 before:ease-out hover:shadow-slate-700 border border-slate-700 py-2 px-4 rounded-xl hover:text-black hover:before:h-56 hover:before:w-56 ml-2">
                <span class="relative z-10">Register</span>
            </a>
            @endauth
        </div>
    </div>
</nav>