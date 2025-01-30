<x-app-layout>
    <!-- HOME START -->
    <section class="h-[50vh] bg-center relative -mt-20 p-6" style="background-image: url({{ Vite::asset('resources/images/coba.jpg') }});">
        <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-30"></div>
        <div class="absolute top-0 left-0 w-full h-full flex justify-center items-center">
            <div class="container mx-auto p-4 text-center">
                <h1 class="text-5xl text-white mb-4">We Are Here For Your Serve</h1>
                <h2 class="text-3xl text-white mb-8">We deliver The best quality product</h2>
                <a href="#" class="text-red hover:before:bg-red relative h-[50px] w-40 overflow-hidden border border-blue-500 bg-white px-3 py-2 text-blue-500 shadow-2xl transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-blue-500 before:transition-all before:duration-500 hover:text-white hover:shadow-blue-500 hover:before:left-0 hover:before:w-full z-0 ">
                    <span class="relative z-10">Shop Now</span>
                </a>
            </div>
        </div>
    </section>
    <!-- HOME END -->

    <!-- SERVICES START -->
    <section class="py-20">
        <div class="container w-full grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <!-- Card 1 -->
            <div class="border border-blue-500 p-5 cursor-pointer rounded-md hover:shadow-2xl hover:-translate-y-1 duration-300 space-y-5 flex flex-col items-center group">
                <div class="flex flex-col items-center gap-5">
                    <div class="bg-pink-300  p-8 rounded-full flex items-center justify-center relative group-hover:bg-blue-500 transition-colors duration-300">
                        <div class="absolute inset-1.5 border-2 border-white rounded-full"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.7" stroke="white" class="w-16 h-16">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-center">Fast Delivery</h3>
                </div>
                <span class="text-sm text-gray-600 text-center">TO YOUR HOME</span>
            </div>

            <!-- Card 2 -->
            <div class="border border-blue-500 p-5 cursor-pointer rounded-md hover:shadow-2xl hover:-translate-y-1 duration-300 space-y-5 flex flex-col items-center group">
                <div class="flex flex-col items-center gap-5">
                    <div class="bg-orange-300  p-8 rounded-full flex items-center justify-center relative group-hover:bg-blue-500 transition-colors duration-300">
                        <div class="absolute inset-1.5 border-2 border-white rounded-full"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.7" stroke="white" class="w-16 h-16">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>

                    </div>
                    <h3 class="text-lg font-bold text-center">Customer Service</h3>
                </div>
                <span class="text-sm text-gray-600 text-center">24/7 SUPPORT</span>
            </div>

            <!-- Card 3 -->
            <div class="border border-blue-500 p-5 cursor-pointer rounded-md hover:shadow-2xl hover:-translate-y-1 duration-300 space-y-5 flex flex-col items-center group">
                <div class="flex flex-col items-center gap-5">
                    <div class="bg-cyan-300  p-8 rounded-full flex items-center justify-center relative group-hover:bg-blue-500 transition-colors duration-300">
                        <div class="absolute inset-1.5 border-2 border-white rounded-full"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke-width="0.7" stroke="white" class="w-16 h-16" viewBox="0 0 24 24" id="box">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.49,7.52a.19.19,0,0,1,0-.08.17.17,0,0,1,0-.07l0-.09-.06-.15,0,0h0l0,0,0,0a.48.48,0,0,0-.09-.11l-.09-.08h0l-.05,0,0,0L16.26,4.45h0l-3.72-2.3A.85.85,0,0,0,12.25,2h-.08a.82.82,0,0,0-.27,0h-.1a1.13,1.13,0,0,0-.33.13L4,6.78l-.09.07-.09.08L3.72,7l-.05.06,0,0-.06.15,0,.09v.06a.69.69,0,0,0,0,.2v8.73a1,1,0,0,0,.47.85l7.5,4.64h0l0,0,.15.06.08,0a.86.86,0,0,0,.52,0l.08,0,.15-.06,0,0h0L20,17.21a1,1,0,0,0,.47-.85V7.63S20.49,7.56,20.49,7.52ZM12,4.17l1.78,1.1L8.19,8.73,6.4,7.63Zm-1,15L5.5,15.81V9.42l5.5,3.4Zm1-8.11L10.09,9.91l5.59-3.47L17.6,7.63Zm6.5,4.72L13,19.2V12.82l5.5-3.4Z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-center">Guaranteed Quality</h3>
                </div>
                <span class="text-sm text-gray-600 text-center">PRODUCT WELL PACKAGE</span>
            </div>

            <!-- Card 4 -->
            <div class="border border-blue-500 p-5 cursor-pointer rounded-md hover:shadow-2xl hover:-translate-y-1 duration-300 space-y-5 flex flex-col items-center group">
                <div class="flex flex-col items-center gap-5">
                    <div class="bg-emerald-300  p-8 rounded-full flex items-center justify-center relative group-hover:bg-blue-500 transition-colors duration-300">
                        <div class="absolute inset-1.5 border-2 border-white rounded-full"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke-width="0.7" stroke="white" class="w-16 h-16" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-center">Affordable Price</h3>
                </div>
                <span class="text-sm text-gray-600 text-center">POCKET-FRIENDLY PRICES</span>
            </div>
        </div>
    </section>
    <!-- SERVICES END -->

</x-app-layout>