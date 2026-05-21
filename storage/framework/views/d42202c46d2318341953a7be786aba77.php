<nav class="fixed top-0 w-full z-50 bg-[#0d0d0d]/90 backdrop-blur border-b border-white/5">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 text-white font-bold text-lg">
            <img src="<?php echo e(asset('images/logo-jb.png')); ?>" alt="Jay's Billiard Logo" class="w-10 h-10 object-contain">
            Jay's Billiard
        </a>

        <!-- Menu Desktop -->
        <div class="hidden md:flex items-center gap-8 text-sm font-bold text-gray-300">
            <a href="<?php echo e(route('home')); ?>"
                class="<?php echo e(request()->routeIs('home') ? 'text-[#00e5ff]' : 'hover:text-white'); ?> transition">Beranda</a>
            <a href="<?php echo e(route('rates')); ?>"
                class="<?php echo e(request()->routeIs('rates') ? 'text-[#00e5ff]' : 'hover:text-white'); ?> transition">Tarif</a>
            <a href="<?php echo e(route('location')); ?>"
                class="<?php echo e(request()->routeIs('location') ? 'text-[#00e5ff]' : 'hover:text-white'); ?> transition">Lokasi</a>
        </div>

        <!-- Auth Buttons -->
        <div class="hidden md:flex items-center gap-3">
            <a href="<?php echo e(route('login')); ?>"
                class="border border-[#00e5ff] text-[#00e5ff] text-sm font-bold px-5 py-2 rounded-md hover:bg-[#00e5ff] hover:text-black transition">
                Login
            </a>
            <a href="<?php echo e(route('register')); ?>"
                class="bg-[#00e5ff] text-black text-sm font-bold px-5 py-2 rounded-md hover:bg-[#00cce6] shadow-md hover:shadow-lg transition">
                Register
            </a>
        </div>
    </div>
</nav><?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/component/c_website/navbar.blade.php ENDPATH**/ ?>