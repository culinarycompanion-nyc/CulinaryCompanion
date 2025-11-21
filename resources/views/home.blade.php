<x-html>
    @vite(['resources/js/homepage.js'])

    <div name="home-page">
        <!-- #f5eee0 -->
        <nav id="home-page-photo-div" class="relative h-screen w-full items-center">
            <!-- <div
                class="text-center absolute inset-0 h-[10vh] w-full flex items-center justify-center bg-[#f5eee0] z-10 drop-shadow-[0_4px_4px_rgba(0,0,0,0.25)]">
            </div> -->
            <img id="home-page-bg-img" src="{{ asset("assets/table.jpg") }}" class="w-full h-full object-cover">
            <div id="title-name"
                class="text-center absolute inset-0 h-[10vh] flex items-center justify-center before:content-[''] before:absolute before:inset-0 before:bg-[#f5eee0] before:drop-shadow-[0_4px_4px_rgba(0,0,0,0.25)] before:z-[-1]">
                <div class="relative flex items-center justify-between">
                    <div class="group relative mr-[25px]">
                        <div id="navMenuToggle"
                            class="sm:hover-trigger w-10 mt-[2vh] h-10 border-[3px] rounded-md [box-shadow:-4px_4px_6px_rgba(182,199,207,0.75)] border-black flex flex-col justify-center items-center gap-[4px] cursor-pointer">
                            <span class="w-6 h-[3px] bg-black"></span>
                            <span class="w-6 h-[3px] bg-black"></span>
                            <span class="w-6 h-[3px] bg-black"></span>
                        </div>
                        <div id="navMenu"
                            class="absolute sm:group-hover:block top-full left-0 z-50 w-32 bg-white border border-gray-300 rounded-md shadow opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-all duration-200">
                            <a class="flex z-50 block px-4 py-2 text-black hover:bg-gray-100" href="/">
                                Home
                            </a>
                            <a class="flex z-50 block px-4 py-2 text-black hover:bg-gray-100" href="/blogs">
                                Blogs
                            </a>
                            <a class="flex z-50 block px-4 py-2 text-black hover:bg-gray-100" href="/about">
                                About Us
                            </a>
                            <a class="flex z-50 block px-4 py-2 text-black hover:bg-gray-100" href="/contact">
                                Contact Us
                            </a>
                        </div>
                    </div>
                    <a class="text-black text-[clamp(2rem,5vw,4rem)] font-serif font-medium [text-shadow:_-4px_4px_6px_rgba(182,199,207,0.75)]"
                        href="/"><img src="{{ asset("assets/header_logo.png") }}" alt="Site Logo" class="h-[8vh]"></a>
                    <!-- #4a3f35 -->
                </div>
            </div>
        </nav>
        <script>
            const toggle = document.getElementById("navMenuToggle");
            const menu = document.getElementById("navMenu");

            toggle.addEventListener("click", function () {
                // Only apply toggle on small screens
                if (window.innerWidth < 768) {
                    menu.classList.toggle("hidden");
                }
            });
        </script>
        <div
            class="relative h-[82vh] pt-[12vh] before:content-[''] before:absolute before:inset-0 before:bg-[#fcf9f1] before:z-[-1]">
            <div class="text-center mb-[4vh] text-[clamp(1.4rem,2vw,2rem)] leading-[clamp(1.5rem,2.5vw,2rem)] pb-2">
                Select your Allergies & Dietary Requirements
            </div>
            <br>
            <div class="flex justify-center z-10">
                <form class="relative" method="post" action="/selections">
                    @csrf
                    <div class="grid grid-cols-6 md:grid-cols-10 justify-center gap-4">
                        <div class="hidden md:block md:col-span-1"></div>
                        <x-checkbox value="soy" label="Soy" :selected="old('checkboxes', [])" />
                        <x-checkbox value="wheat" label="Wheat" :selected="old('checkboxes', [])" />
                        <x-checkbox value="dairy" label="Dairy" :selected="old('checkboxes', [])" />
                        <div class="col-span-1 md:hidden"></div>
                        <x-checkbox value="eggs" label="Eggs" :selected="old('checkboxes', [])" />
                        <x-checkbox value="fish" label="Fish" :selected="old('checkboxes', [])" />
                        <div class="col-span-1 md:hidden"></div>
                        <x-checkbox value="shellfish" label="Shellfish" :selected="old('checkboxes', [])" />
                        <x-checkbox value="tree_nuts" label="Tree Nuts" :selected="old('checkboxes', [])" />
                        <x-checkbox value="peanuts" label="Peanuts" :selected="old('checkboxes', [])" />
                        <div class="col-span-1 md:hidden"></div>
                        <x-checkbox value="sesame" label="Sesame" :selected="old('checkboxes', [])" />
                        <div class="hidden md:block md:col-span-1"></div>
                        <x-checkbox value="glutenfree" label="Gluten-Free" :selected="old('checkboxes', [])" />
                        <div class="col-span-1 md:hidden"></div>
                        <x-checkbox value="vegetarian" label="Vegetarian" :selected="old('checkboxes', [])" />
                        <x-checkbox value="vegan" label="Vegan" :selected="old('checkboxes', [])" />
                        <x-checkbox value="pescatarian" label="Pescatarian" :selected="old('checkboxes', [])" />
                    </div>

                    <div>
                        <button type="submit"
                            class="mt-10 absolute right-[0%] lg:right-[-15%] text-sm md:text-lg bg-[#d0dbb9] border-2 border-[#222] rounded-[30px] shadow-[4px_4px_0_0_#222] text-[#000] cursor-pointer inline-block font-semibold text-[18px] py-[1vh] px-[25px] text-center touch-manipulation transition-colors hover:bg-[#aab491] active:shadow-[2px_2px_0_0_#333] active:translate-x-[2px] active:translate-y-[2px]">Continue</button>
                    </div>
                </form>
            </div>
        </div>
        <x-footer></x-footer>
    </div>
</x-html>