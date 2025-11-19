<nav id="home-page-photo-div"
    class="z-50 relative bg-[#f5eee0] h-[10vh] w-full drop-shadow-[0_4px_4px_rgba(0,0,0,0.25)]">
    <div id="title-name" class="text-center absolute inset-0 h-[10vh] flex items-center justify-center">
        <div class="relative flex items-center justify-between">
            <!-- Menu Toggle -->
            <div class="relative mr-[25px]">
                <div id="navMenuToggle"
                    class="mt-[2vh] w-10 h-10 border-[3px] rounded-md [box-shadow:-4px_4px_6px_rgba(182,199,207,0.75)] border-black flex flex-col justify-center items-center gap-[4px] cursor-pointer">
                    <span class="w-6 h-[3px] bg-black"></span>
                    <span class="w-6 h-[3px] bg-black"></span>
                    <span class="w-6 h-[3px] bg-black"></span>
                </div>

                <!-- Dropdown Menu -->
                <div id="navMenu"
                    class="absolute hidden z-50 top-full left-0 w-32 bg-white border border-gray-300 rounded-md shadow transition-all duration-200 md:group-hover:block">
                    <a class="flex block px-4 py-2 text-black hover:bg-gray-100" href="/">
                        Home
                    </a>
                    <a class="flex block px-4 py-2 text-black hover:bg-gray-100" href="/blogs">
                        Blogs
                    </a>
                    <a class="flex block px-4 py-2 text-black hover:bg-gray-100" href="/about">
                        About Us
                    </a>
                    <a class="flex block px-4 py-2 text-black hover:bg-gray-100" href="/contact">
                        Contact Us
                    </a>
                </div>
            </div>

            <!-- Logo -->
            <a class="text-black text-[clamp(2rem,5vw,4rem)] font-serif font-medium [text-shadow:_-4px_4px_6px_rgba(182,199,207,0.75)]"
                href="/">
                <img src="{{ asset('assets/header_logo.png') }}" alt="Site Logo" class="h-[8vh]">
            </a>
        </div>
    </div>
</nav>

<!-- JavaScript for Mobile Toggle -->
<script>
    document.getElementById("navMenuToggle").addEventListener("click", function () {
        const menu = document.getElementById("navMenu");
        menu.classList.toggle("hidden");
    });
</script>




<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('navMenuToggle');
        const menu = document.getElementById('navMenu');

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
</script> -->