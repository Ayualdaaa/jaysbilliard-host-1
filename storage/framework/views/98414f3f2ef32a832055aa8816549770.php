<?php $__env->startSection('title', "Jay's Billiard — Level Up Your Game"); ?>

<?php $__env->startSection('content'); ?>

<section class="relative min-h-screen flex items-center justify-center text-center overflow-hidden">
    
    <div class="absolute inset-0 bg-[#0d0d0d]" style="background-image: url('/images/billiard bg.png'); background-size: cover; background-position: center 20%; background-repeat: no-repeat;">
        
        <div class="absolute inset-0 bg-black/55 backdrop-blur-sm"></div>
    </div>

    <div class="relative z-10 max-w-3xl mx-auto px-6 pt-24 md:pt-0">
        
        <span class="inline-flex items-center gap-2 text-xs bg-cyan-500/10 text-cyan-400 border border-cyan-400/40 rounded-full px-4 py-1.5 mb-8 uppercase tracking-wider">
            <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse-custom"></span>
            Sekarang Buka di Tegal
        </span>

        
        <h1 class="text-5xl md:text-7xl font-black uppercase leading-tight mb-6 text-white tracking-wide">
            Welcome To<br>
            <span class="text-neon">Billiard Jay's</span>
        </h1>

        
        <p class="text-white/65 text-base leading-relaxed max-w-2xl mx-auto mb-10">
            Tempat di mana setiap permainan terasa lebih eksklusif. Pesan meja favoritmu sekarang dan rasakan pengalaman billiard dengan standar profesional dan suasana premium
        </p>

        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center gap-2 bg-cyan-400 text-black font-bold text-sm uppercase tracking-wider px-8 py-3.5 rounded-lg border-2 border-cyan-400 transition-all hover:bg-cyan-500 hover:border-cyan-500 hover:shadow-neon hover:-translate-y-0.5 w-full sm:w-auto justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                Book a Table
            </a>
            <a href="<?php echo e(route('rates')); ?>" class="inline-flex items-center gap-2 bg-transparent text-white font-semibold text-sm uppercase tracking-wider px-8 py-3.5 rounded-lg border-2 border-white/30 transition-all hover:border-white/60 hover:bg-white/5 hover:-translate-y-0.5 w-full sm:w-auto justify-center">
                Lihat Tarif
            </a>
        </div>
    </div>
</section>


<section class="py-24 px-6 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row items-start justify-between gap-6 mb-14">
        <div>
            <p class="text-cyan-400 text-xs font-bold uppercase tracking-widest mb-2">Mengapa Memilih Kami</p>
            <h2 class="text-4xl font-bold text-white">Lebih Dari Sekadar Permainan</h2>
        </div>
        <p class="text-gray-400 max-w-sm md:text-right text-sm leading-relaxed">
            Kami telah membangun ruang di mana para profesional & pemula
            dapat menikmati istirahat yang sempurna. Setiap detail dirancang
            untuk kenyamanan Anda.
        </p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <?php echo $__env->make('component.c_website.feature-card', [
            'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00e5ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9z"/><path d="M11 3l1 6h10"/><path d="M2 9h10l1-6"/><path d="M12 22l1-13"/></svg>',
            'title'       => 'Peralatan Pro',
            'description' => 'Nikmati pengalaman bermain maksimal dengan sewa Peralatan Pro khusus untuk penggunaan di Ruangan yang Nyaman.'
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('component.c_website.feature-card', [
            'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00e5ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 22h8"/><path d="M12 11v11"/><path d="M10 22V6.5a.5.5 0 0 0-.5-.5 3.498 3.498 0 0 1-3.237-4.766A.5.5 0 0 1 6.73 1h10.54a.5.5 0 0 1 .467.234A3.498 3.498 0 0 1 14.5 6a.5.5 0 0 0-.5.5V22"/></svg>',
            'title'       => 'F&B Area',
            'description' => 'Sajian rasa untuk menemani tiap kemenangan. Nikmati kemudahan akses menu favorit tanpa harus meninggalkan meja di Ruang Nyaman. Stay focused, stay cool.'
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('component.c_website.feature-card', [
            'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00e5ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>',
            'title'       => 'Fasilitas Utama',
            'description' => 'Ruang pribadi yang kedap suara dengan layanan eksklusif untuk pesta dan pertandingan serius.'
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</section>




<section class="py-24 px-6 max-w-7xl mx-auto">
    <div class="grid md:grid-cols-2 gap-12 items-start">
        
        <div>
            <h2 class="text-4xl font-bold text-white mb-10">Temukan Kami di Tegal</h2>
            <div class="space-y-6 text-sm text-gray-300">
                <div class="flex gap-4">
                    <span class="flex items-center justify-center w-10 h-10 min-w-10 bg-cyan-400/10 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00e5ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </span>
                    <div>
                        <p class="text-white font-semibold mb-1">Alamat</p>
                        <p>Jl. R.A. Kartini No.44, Mangkukusuman, Kec. Tegal Tim., Kota Tegal, Jawa Tengah 52131</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <span class="flex items-center justify-center w-10 h-10 min-w-10 bg-cyan-400/10 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00e5ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                    <div>
                        <p class="text-white font-semibold mb-1">Jam Buka</p>
                        <p>Setiap Hari</p>
                        <p>14.00-01.00 WIB</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <span class="flex items-center justify-center w-10 h-10 min-w-10 bg-cyan-400/10 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00e5ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </span>
                    <div>
                        <p class="text-white font-semibold mb-1">Kontak</p>
                        <p>+62 812 3456 7890</p>
                        <p>booking@jaysbilliard.com</p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="rounded-2xl overflow-hidden h-80 border border-white/10">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.152290758776!2d109.13612127504331!3d-6.872349093126373!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fb900340ba34d%3A0x7a438cc8b3fd1052!2sJay&#39;s%20Billiard!5e0!3m2!1sid!2sid!4v1772697633190!5m2!1sid!2sid"
                class="w-full h-full"
                style="border:0;"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/website/home.blade.php ENDPATH**/ ?>