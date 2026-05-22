<nav class="fixed top-0 w-full z-50 bg-[#0d0d0d]/90 backdrop-blur border-b border-white/5">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-white font-bold text-lg">
            <img src="{{ asset('images/logo-jb.png') }}" alt="Jay's Billiard Logo" class="w-10 h-10 object-contain">
            Jay's Billiard
        </a>

        <!-- Menu Desktop -->
        <div class="hidden md:flex items-center gap-8 text-sm font-bold text-gray-300">
            <a href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'text-[#00e5ff]' : 'hover:text-white' }} transition">Beranda</a>
            <a href="{{ route('rates') }}"
                class="{{ request()->routeIs('rates') ? 'text-[#00e5ff]' : 'hover:text-white' }} transition">Tarif</a>
            <a href="{{ route('location') }}"
                class="{{ request()->routeIs('location') ? 'text-[#00e5ff]' : 'hover:text-white' }} transition">Lokasi</a>
        </div>

        <!-- Auth Buttons (Desktop) -->
        <div class="hidden md:flex items-center gap-3">
            <a href="{{ route('login') }}"
                class="border border-[#00e5ff] text-[#00e5ff] text-sm font-bold px-5 py-2 rounded-md hover:bg-[#00e5ff] hover:text-black transition">
                Login
            </a>
            <a href="{{ route('register') }}"
                class="bg-[#00e5ff] text-black text-sm font-bold px-5 py-2 rounded-md hover:bg-[#00cce6] shadow-md hover:shadow-lg transition">
                Register
            </a>
        </div>

        <!-- Hamburger Button (Mobile) -->
        <button id="mobile-menu-toggle" class="block md:hidden text-gray-300 hover:text-white focus:outline-none">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu (hidden by default) -->
    <div id="mobile-menu" class="hidden md:hidden bg-[#0d0d0d]/95 border-t border-white/5 px-6 py-4 space-y-4">
        <a href="{{ route('home') }}" class="block text-sm font-bold {{ request()->routeIs('home') ? 'text-[#00e5ff]' : 'text-gray-300 hover:text-white' }} transition">Beranda</a>
        <a href="{{ route('rates') }}" class="block text-sm font-bold {{ request()->routeIs('rates') ? 'text-[#00e5ff]' : 'text-gray-300 hover:text-white' }} transition">Tarif</a>
        <a href="{{ route('location') }}" class="block text-sm font-bold {{ request()->routeIs('location') ? 'text-[#00e5ff]' : 'text-gray-300 hover:text-white' }} transition">Lokasi</a>
        <div class="pt-4 border-t border-white/5 flex flex-col gap-3">
            <a href="{{ route('login') }}" class="text-center border border-[#00e5ff] text-[#00e5ff] text-sm font-bold px-5 py-2 rounded-md hover:bg-[#00e5ff] hover:text-black transition">
                Login
            </a>
            <a href="{{ route('register') }}" class="text-center bg-[#00e5ff] text-black text-sm font-bold px-5 py-2 rounded-md hover:bg-[#00cce6] shadow-md transition">
                Register
            </a>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');
        
        if (toggle && menu) {
            toggle.addEventListener('click', function() {
                menu.classList.toggle('hidden');
            });
        }
    });
</script>