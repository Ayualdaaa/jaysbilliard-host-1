<?php $__env->startSection('title', 'Tarif — Jay\'s Billiard'); ?>

<?php $__env->startSection('content'); ?>
    
    <section class="text-center pt-32 pb-8 px-6 max-w-3xl mx-auto">
        <h1 class="text-5xl md:text-6xl font-black uppercase text-white mb-4 tracking-wide">TARIF KAMI</h1>
        <p class="text-white/55 text-base leading-relaxed">
            Nikmati permainan terbaik di meja reguler kami. Pilih tarif sore atau malam yang sesuai dengan waktu santai Anda
            setiap harinya.
        </p>
    </section>

    
    <section class="px-6 pb-24 max-w-7xl mx-auto">
        <div class="max-w-xl mx-auto">
            <div
                class="bg-[#0d0e12] border border-white/10 rounded-[2.5rem] overflow-hidden flex flex-col transition-all duration-500 hover:-translate-y-4 hover:border-cyan-400/30 group shadow-[0_30px_60px_-15px_rgba(0,0,0,0.7)]">
                
                <div class="h-72 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0d0e12] via-transparent to-transparent z-10"></div>
                    <img src="<?php echo e(asset('images/meja_premium.png')); ?>" alt="Reguler Table"
                        class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">

                    
                    <div class="absolute top-8 left-8 z-20">
                        <span
                            class="bg-[#113a3e]/60 backdrop-blur-md text-[#00f2ff] border border-[#00f2ff]/30 px-5 py-2 rounded-full text-[11px] font-black uppercase tracking-[0.15em]">
                            MEJA REGULER
                        </span>
                    </div>

                    
                    <div class="absolute bottom-1 left-8 z-20">
                        <h3 class="text-4xl font-black text-white uppercase tracking-tight">JAY'S BILLIARD PRICE LIST</h3>
                    </div>
                </div>

                
                <div class="p-10 flex flex-col gap-10 flex-1">
                    
                    <div class="border-b border-white/5 pb-6">
                        <p class="text-white/60 text-lg font-medium italic">Open Daily: 14:00 - 01:00 WIB</p>
                    </div>

                    
                    <div class="space-y-6">
                        <h4 class="text-[#00f2ff] text-xl font-black uppercase tracking-wide">HAPPY HOUR (SORE)</h4>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white/10 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-white/60">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                </div>
                                <span class="text-white text-2xl font-bold tracking-tight">14:00 - 17:00</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-white text-3xl font-black tracking-tight">Rp 25.000</span>
                                <span class="text-white/40 text-xl font-bold ml-1">/ Jam</span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="space-y-6">
                        <h4 class="text-[#00f2ff] text-xl font-black uppercase tracking-wide">PRIME TIME (MALAM)</h4>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white/10 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-white/60">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                </div>
                                <span class="text-white text-2xl font-bold tracking-tight">18:00 - 01:00</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-white text-3xl font-black tracking-tight">Rp 35.000</span>
                                <span class="text-white/40 text-xl font-bold ml-1">/ Jam</span>
                            </div>
                        </div>
                    </div>



                    
                    <div class="mt-6 pt-10 border-t border-white/5">
                        <a href="<?php echo e(route('login')); ?>"
                            class="flex items-center justify-center gap-4 w-full bg-[#00f2ff] text-black py-5 rounded-[1.25rem] text-sm font-black uppercase tracking-[0.1em] transition-all duration-300 hover:bg-cyan-300 hover:shadow-[0_0_40px_rgba(0,242,255,0.6)] hover:-translate-y-1 active:scale-95">
                            BOOK MEJA INI
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-12 pb-20 px-6 max-w-[85rem] mx-auto border-t border-white/5">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="flex gap-4 items-start">
                <div class="flex items-center justify-center w-10 h-10 min-w-10 bg-primary/10 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#00e5ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="16" x2="12" y2="12" />
                        <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-1.5">Kebijakan Pemesanan</h4>
                    <p class="text-white/45 text-xs leading-relaxed">Pemesanan ditahan selama 15 menit setelah waktu yang
                        dijadwalkan. Pembatalan harus dilakukan setidaknya 2 jam sebelumnya.</p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="flex items-center justify-center w-10 h-10 min-w-10 bg-primary/10 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#00e5ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-1.5">Fasilitas Meja</h4>
                    <p class="text-white/45 text-xs leading-relaxed">Tersedia 4 meja reguler berkualitas yang siap
                        digunakan. Setiap meja nyaman digunakan untuk bermain maksimal hingga 4 orang.</p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="flex items-center justify-center w-10 h-10 min-w-10 bg-primary/10 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#00e5ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8h1a4 4 0 0 1 0 8h-1" />
                        <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z" />
                        <line x1="6" y1="1" x2="6" y2="4" />
                        <line x1="10" y1="1" x2="10" y2="4" />
                        <line x1="14" y1="1" x2="14" y2="4" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-1.5">Makanan dari Luar</h4>
                    <p class="text-white/45 text-xs leading-relaxed">Makanan dan minuman dari luar sangat dilarang. Silakan
                        tanyakan pilihan menu yang tersedia kepada staff kami.</p>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/website/tarif.blade.php ENDPATH**/ ?>