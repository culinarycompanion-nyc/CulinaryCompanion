<x-layout>
    <!-- <div class="h-full">
        {{ implode(', ', $selectedOptions) }}
    </div>

    <div>
        {{ $restaurant->name }} ({{ $restaurant->address }})</a><br>
    </div> -->
    <style>
        .expandable {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }

        .group:hover .expandable {
            max-height: 10rem;
            /* adjust as needed */
        }
    </style>



    <div class="p-[2vh] h-[82vh]">
        <div class="bg-[#d0dbb9] h-full rounded-xl flex flex-col">
            <div class="text-black text-center flex flex-col items-center">
                <span class="text-[clamp(1rem,5vw,2.4rem)] font-['Trueno',sans-serif] font-normal">
                    {{ $restaurant->name }}
                </span>
                <span class="text-xs md:text-sm hover:underline">
                    <a href="{{ $restaurant->google_maps_link }}" target="_blank">{{ $restaurant->address }}</a>
                </span>
                @php
                    $rating = round($restaurant->rating, 1); // example: 3.8
                    $fullStars = floor($rating);             // full stars: 3
                    $halfStar = ($rating - $fullStars > 0 && $rating - $fullStars < 1) ? 1 : 0;
                    $emptyStars = 5 - $fullStars - $halfStar;
                @endphp
                <div class="mt-1 grid grid-cols-1 md:grid-cols-2 items-center gap-2 text-sm">
                    <!-- ★★★⯪☆ -->
                    <div class="flex">
                        <div class="flex items-center">
                            {{-- Full stars --}}
                            @for ($i = 0; $i < $fullStars; $i++)
                                <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="currentColor" stroke="black"
                                    stroke-width="1" stroke-linejoin="round" aria-hidden="true">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            @endfor

                            {{-- Half star --}}
                            @if ($halfStar)
                                <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" stroke="black"
                                    stroke-width="1" stroke-linejoin="round" aria-hidden="true">
                                    <defs>
                                        <clipPath id="half-star-clip">
                                            <rect x="0" y="0" width="12" height="24" />
                                        </clipPath>
                                    </defs>
                                    {{-- gray background --}}
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                                        fill="currentColor" class="text-gray-300" />
                                    {{-- clipped black fill --}}
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                                        fill="currentColor" class="text-black" clip-path="url(#half-star-clip)" />
                                </svg>
                            @endif

                            {{-- Empty stars --}}
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24" fill="currentColor" stroke="black"
                                    stroke-width="1" stroke-linejoin="round" aria-hidden="true">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            @endfor
                        </div>


                        ({{ $restaurant->rating }})
                        @if ($restaurant->restaurant_website)
                            <span class="text-gray-700 ml-2 italic">
                                {{ $restaurant->cuisine }}
                            </span>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <div class="relative group">
                            <div class="cursor-pointer w-fit text-blue-600 underline text-sm pb-1">Operating Hours</div>
                            <div
                                class="absolute left-0 mt-1 p-1 w-48 text-xs text-black bg-gray-50 border rounded shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition z-50">
                                {!! nl2br(e($restaurant->operating_hours)) !!}
                            </div>
                        </div>
                        @if ($restaurant->instagram_link)
                            <a href="{{$restaurant->instagram_link}}" class="hover:scale-125" target="_blank">
                                <svg height="18" width="18" viewBox="0 0 24 24" fill="#E1306C"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.0301.084c-1.2768.0602-2.1487.264-2.911.5634-.7888.3075-1.4575.72-2.1228 1.3877-.6652.6677-1.075 1.3368-1.3802 2.127-.2954.7638-.4956 1.6365-.552 2.914-.0564 1.2775-.0689 1.6882-.0626 4.947.0062 3.2586.0206 3.6671.0825 4.9473.061 1.2765.264 2.1482.5635 2.9107.308.7889.72 1.4573 1.388 2.1228.6679.6655 1.3365 1.0743 2.1285 1.38.7632.295 1.6361.4961 2.9134.552 1.2773.056 1.6884.069 4.9462.0627 3.2578-.0062 3.668-.0207 4.9478-.0814 1.28-.0607 2.147-.2652 2.9098-.5633.7889-.3086 1.4578-.72 2.1228-1.3881.665-.6682 1.0745-1.3378 1.3795-2.1284.2957-.7632.4966-1.636.552-2.9124.056-1.2809.0692-1.6898.063-4.948-.0063-3.2583-.021-3.6668-.0817-4.9465-.0607-1.2797-.264-2.1487-.5633-2.9117-.3084-.7889-.72-1.4568-1.3876-2.1228C21.2982 1.33 20.628.9208 19.8378.6165 19.074.321 18.2017.1197 16.9244.0645 15.6471.0093 15.236-.005 11.977.0014 8.718.0076 8.31.0215 7.0301.0839m.1402 21.6932c-1.17-.0509-1.8053-.2453-2.2287-.408-.5606-.216-.96-.4771-1.3819-.895-.422-.4178-.6811-.8186-.9-1.378-.1644-.4234-.3624-1.058-.4171-2.228-.0595-1.2645-.072-1.6442-.079-4.848-.007-3.2037.0053-3.583.0607-4.848.05-1.169.2456-1.805.408-2.2282.216-.5613.4762-.96.895-1.3816.4188-.4217.8184-.6814 1.3783-.9003.423-.1651 1.0575-.3614 2.227-.4171 1.2655-.06 1.6447-.072 4.848-.079 3.2033-.007 3.5835.005 4.8495.0608 1.169.0508 1.8053.2445 2.228.408.5608.216.96.4754 1.3816.895.4217.4194.6816.8176.9005 1.3787.1653.4217.3617 1.056.4169 2.2263.0602 1.2655.0739 1.645.0796 4.848.0058 3.203-.0055 3.5834-.061 4.848-.051 1.17-.245 1.8055-.408 2.2294-.216.5604-.4763.96-.8954 1.3814-.419.4215-.8181.6811-1.3783.9-.4224.1649-1.0577.3617-2.2262.4174-1.2656.0595-1.6448.072-4.8493.079-3.2045.007-3.5825-.006-4.848-.0608M16.953 5.5864A1.44 1.44 0 1 0 18.39 4.144a1.44 1.44 0 0 0-1.437 1.4424M5.8385 12.012c.0067 3.4032 2.7706 6.1557 6.173 6.1493 3.4026-.0065 6.157-2.7701 6.1506-6.1733-.0065-3.4032-2.771-6.1565-6.174-6.1498-3.403.0067-6.156 2.771-6.1496 6.1738M8 12.0077a4 4 0 1 1 4.008 3.9921A3.9996 3.9996 0 0 1 8 12.0077" />
                                </svg>
                            </a>
                        @endif
                        @if ($restaurant->restaurant_website)
                            <a href="{{$restaurant->restaurant_website}}" class="hover:scale-125" target="_blank">
                                <svg height="18" width="18" viewBox="0 0 420 420" fill="none" stroke="#000"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-width="26" d="M209,15a195,195 0 1,0 2,0z" />
                                    <path stroke-width="18"
                                        d="m210,15v390m195-195H15M59,90a260,260 0 0,0 302,0 m0,240 a260,260 0 0,0-302,0M195,20a250,250 0 0,0 0,382 m30,0 a250,250 0 0,0 0-382" />
                                </svg>
                            </a>
                        @endif
                        @if ($restaurant->google_maps_link)
                            <a href="{{$restaurant->google_maps_link}}" class="hover:scale-125" target="_blank">
                                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <title>Google Maps</title>
                                    <path
                                        d="M19.527 4.799c1.212 2.608.937 5.678-.405 8.173-1.101 2.047-2.744 3.74-4.098 5.614-.619.858-1.244 1.75-1.669 2.727-.141.325-.263.658-.383.992-.121.333-.224.673-.34 1.008-.109.314-.236.684-.627.687h-.007c-.466-.001-.579-.53-.695-.887-.284-.874-.581-1.713-1.019-2.525-.51-.944-1.145-1.817-1.79-2.671L19.527 4.799zM8.545 7.705l-3.959 4.707c.724 1.54 1.821 2.863 2.871 4.18.247.31.494.622.737.936l4.984-5.925-.029.01c-1.741.601-3.691-.291-4.392-1.987a3.377 3.377 0 0 1-.209-.716c-.063-.437-.077-.761-.004-1.198l.001-.007zM5.492 3.149l-.003.004c-1.947 2.466-2.281 5.88-1.117 8.77l4.785-5.689-.058-.05-3.607-3.035zM14.661.436l-3.838 4.563a.295.295 0 0 1 .027-.01c1.6-.551 3.403.15 4.22 1.626.176.319.323.683.377 1.045.068.446.085.773.012 1.22l-.003.016 3.836-4.561A8.382 8.382 0 0 0 14.67.439l-.009-.003zM9.466 5.868L14.162.285l-.047-.012A8.31 8.31 0 0 0 11.986 0a8.439 8.439 0 0 0-6.169 2.766l-.016.018 3.665 3.084z" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="mt-1 flex flex-wrap gap-2 text-sm">
                    @if ($restaurant->doordash)
                        <span class="bg-gray-100 cursor-pointer hover:bg-gray-200 text-gray-700 px-2 py-1 rounded"><a
                                target="_blank"
                                href="/redirect/{{ base64_encode($restaurant->doordash) }}">DoorDash</a></span>
                    @endif
                    @if ($restaurant->grubhub)
                        <span class="bg-gray-100 cursor-pointer hover:bg-gray-200 text-gray-700 px-2 py-1 rounded"><a
                                target="_blank"
                                href="/redirect/{{ base64_encode($restaurant->grubhub) }}">Grubhub</a></span>
                    @endif
                    @if ($restaurant->ubereats)
                        <span class="bg-gray-100 cursor-pointer hover:bg-gray-200 text-gray-700 px-2 py-1 rounded"><a
                                target="_blank"
                                href="/redirect/{{ base64_encode($restaurant->ubereats) }}">UberEats</a></span>
                    @endif
                    @if ($restaurant->restaurant_order_link)
                        <span class="bg-blue-100 cursor-pointer hover:bg-blue-200 text-blue-800 px-2 py-1 rounded"><a
                                target="_blank"
                                href="/redirect/{{ base64_encode($restaurant->restaurant_order_link) }}">Online
                                Order</a></span>
                    @endif
                </div>
                <div class="mt-1 items-center gap-2 text-sm">
                    @if ($restaurant->source)
                        <span class="text-xs md:text-sm hover:underline">
                            <a href="{{ $restaurant->source }}" target="_blank">Source</a>
                        </span>
                    @endif
                    @if ($restaurant->last_updated)
                        <span class="text-gray-700 ml-2 italic">
                            Last Updated: {{ $restaurant->last_updated }}
                        </span>
                    @endif

                </div>
            </div>

            <div class="bg-[#f5eee0] m-4 mt-1 rounded-xl overflow-y-hidden flex-1 relative">
                <div class="relative inline-block z-50">
                    <button id="filterToggle"
                        class="bg-[#d0dbb9] hover:bg-[#aab491] mt-3 ml-8 h-fit py-1 px-4 rounded-xl border-2 border-black cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                            viewBox="0 0 256 256" xml:space="preserve"
                            class="h-[16px] w-[16px] md:h-[24px] md:w-[24px]">
                            <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                <path
                                    d="M 87 77.103 H 54.88 c -1.657 0 -3 -1.343 -3 -3 s 1.343 -3 3 -3 H 87 c 1.657 0 3 1.343 3 3 S 88.657 77.103 87 77.103 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path
                                    d="M 54.114 18.898 H 3 c -1.657 0 -3 -1.343 -3 -3 s 1.343 -3 3 -3 h 51.114 c 1.657 0 3 1.343 3 3 S 55.771 18.898 54.114 18.898 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path
                                    d="M 87 48 H 31.097 c -1.657 0 -3 -1.343 -3 -3 c 0 -1.657 1.343 -3 3 -3 H 87 c 1.657 0 3 1.343 3 3 C 90 46.657 88.657 48 87 48 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path
                                    d="M 35.885 77.103 H 3 c -1.657 0 -3 -1.343 -3 -3 s 1.343 -3 3 -3 h 32.885 c 1.657 0 3 1.343 3 3 S 37.542 77.103 35.885 77.103 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path
                                    d="M 12.868 48 H 3 c -1.657 0 -3 -1.343 -3 -3 c 0 -1.657 1.343 -3 3 -3 h 9.868 c 1.657 0 3 1.343 3 3 C 15.868 46.657 14.524 48 12.868 48 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path
                                    d="M 87 18.898 H 72.521 c -1.657 0 -3 -1.343 -3 -3 s 1.343 -3 3 -3 H 87 c 1.657 0 3 1.343 3 3 S 88.657 18.898 87 18.898 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path
                                    d="M 54.114 86.217 H 35.885 c -1.657 0 -3 -1.343 -3 -3 V 64.987 c 0 -1.657 1.343 -3 3 -3 h 18.229 c 1.657 0 3 1.343 3 3 v 18.229 C 57.114 84.874 55.771 86.217 54.114 86.217 z M 38.885 80.217 h 12.229 V 67.987 H 38.885 V 80.217 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path
                                    d="M 31.097 57.114 H 12.868 c -1.657 0 -3 -1.343 -3 -3 V 35.885 c 0 -1.657 1.343 -3 3 -3 h 18.229 c 1.657 0 3 1.343 3 3 v 18.229 C 34.097 55.771 32.754 57.114 31.097 57.114 z M 15.868 51.114 h 12.229 V 38.885 H 15.868 V 51.114 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path
                                    d="M 72.344 28.013 H 54.114 c -1.657 0 -3 -1.343 -3 -3 V 6.783 c 0 -1.657 1.343 -3 3 -3 h 18.229 c 1.657 0 3 1.343 3 3 v 18.229 C 75.344 26.669 74.001 28.013 72.344 28.013 z M 57.114 22.013 h 12.229 V 9.783 H 57.114 V 22.013 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            </g>
                        </svg>
                    </button>
                    <div id="filterMenu"
                        class="hidden absolute top-12 left-0 z-50 w-[400px] bg-white border border-gray-300 rounded-lg shadow-lg p-4 transition-all duration-300 ease-in-out">

                        <h2 class="text-lg font-semibold mb-3">Allergies & Dietary Requirements</h2>

                        <form method="POST" action="/selections">
                            @csrf
                            <input type="hidden" name="rest" value="{{ $restaurant->id }}" />
                            <div class="space-y-2 overflow-y-auto pr-2">
                                <div class="grid grid-cols-4 justify-center gap-2">
                                    <x-smallcheckbox value="soy" label="Soy" :selected="$selectedOptions" />
                                    <x-smallcheckbox value="wheat" label="Wheat" :selected="$selectedOptions" />
                                    <x-smallcheckbox value="dairy" label="Dairy" :selected="$selectedOptions" />
                                    <x-smallcheckbox value="eggs" label="Eggs" :selected="$selectedOptions" />
                                    <x-smallcheckbox value="fish" label="Fish" :selected="$selectedOptions" />
                                    <x-smallcheckbox value="shellfish" label="Shellfish" :selected="$selectedOptions" />
                                    <x-smallcheckbox value="tree_nuts" label="Tree Nuts" :selected="$selectedOptions" />
                                    <x-smallcheckbox value="peanuts" label="Peanuts" :selected="$selectedOptions" />
                                    <x-smallcheckbox value="sesame" label="Sesame" :selected="$selectedOptions" />
                                    <x-smallcheckbox value="glutenfree" label="Gluten-Free"
                                        :selected="$selectedOptions" />
                                    <x-smallcheckbox value="vegetarian" label="Vegetarian"
                                        :selected="$selectedOptions" />
                                    <x-smallcheckbox value="vegan" label="Vegan" :selected="$selectedOptions" />
                                    <x-smallcheckbox value="pescatarian" label="Pescatarian"
                                        :selected="$selectedOptions" />
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit"
                                    class="w-1/2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                                    Apply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @if(count($foodItems) === 0)
                    <div class="text-center mt-8 px-4">Sorry! We couldn't find anything matching your prefereneces
                        currently!
                    </div>
                @endif
                <div class="absolute inset-0 flex flex-col overflow-y-auto items-center">
                    @foreach ($foodItems as $menuType => $dishTypes)
                        <div class="bg-white h-fit text-lg md:text-2xl pb-1 px-8 rounded-3xl mt-2 border-2 border-black">
                            {{ count($foodItems) === 1 ? 'Menu' : $menuType . ' Menu' }}
                        </div>
                        @foreach ($dishTypes as $dishType => $dishes)
                            <div class="w-[96%] bg-[#fcf9f1] mt-2 pt-1 rounded-xl max-w-[75rem] shadow">
                                <span class="text-[1.075rem] font-medium md:text-[1.35rem] px-6">{{ $dishType }}</span>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 items-start p-4">
                                    @foreach ($dishes as $dish)
                                        <div
                                            class="group bg-white p-2 pb-1 rounded-xl shadow hover:shadow-xl transition duration-300">
                                            <div class="flex justify-center items-center text-center">
                                                <h4 class="font-semibold text-base md:text-lg text-gray-800">
                                                    {{ \Illuminate\Support\Str::title(strtolower($dish->name)) }}
                                                </h4>
                                            </div>
                                            @if (!empty(trim($dish->description)))
                                                <div class="expandable mt-2 text-xs md:text-sm text-gray-600">
                                                    {{ $dish->description }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('filterToggle');
            const menu = document.getElementById('filterMenu');

            toggleBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });

            // Hide menu when clicking outside
            document.addEventListener('click', function (e) {
                if (!menu.contains(e.target) && !toggleBtn.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>




</x-layout>

<!-- #c7cfb6 -->
<!-- #cfb6b6 -->
<!-- #cfc7b6 -->
<!-- #cfb6a1 -->