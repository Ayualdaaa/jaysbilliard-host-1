<?php $__env->startSection('title', "Dashboard — Jay's Billiard"); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn-neon {
            background: #00f2ff;
            color: #000;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 0 25px rgba(0, 242, 255, 0.4);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-neon:hover { transform: translateY(-2px); box-shadow: 0 0 35px rgba(0, 242, 255, 0.6); }
        .btn-ghost {
            background: rgba(255, 255, 255, 0.03);
            color: #fff;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }
        .btn-ghost:hover { background: rgba(255, 255, 255, 0.08); border-color: rgba(255, 255, 255, 0.2); }
        
        .stats-cyan .card-icon { color: #00f2ff; background: rgba(0, 242, 255, 0.08); box-shadow: inset 0 0 15px rgba(0, 242, 255, 0.1); }
        
        /* Fallback fixes for flex overflow */
        .prevent-overflow {
            min-width: 0 !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
        }
        
        @media (max-width: 768px) {
            .mobile-full { width: 100% !important; }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="p-3 md:p-8 lg:p-10 w-full max-w-7xl mx-auto box-border overflow-hidden animate-[fadeIn_0.5s_ease-out]">

        
        <div class="bg-[#0a0b0d] border border-[#00f2ff]/10 rounded-3xl md:rounded-[2.5rem] p-5 md:p-12 mb-6 md:mb-12 shadow-[0_20px_40px_rgba(0,0,0,0.4)] relative overflow-hidden flex flex-col md:flex-row justify-between items-center text-center md:text-left w-full">
            <div class="relative z-10 w-full min-w-0 prevent-overflow">
                <h1 class="text-3xl md:text-5xl lg:text-[3.8rem] font-black text-white leading-tight break-all md:break-words prevent-overflow">
                    Halo, <?php echo e(Auth::user()->name); ?>!
                </h1>
                <p class="text-white/40 text-sm md:text-lg max-w-xl mt-3 md:mt-5 mx-auto md:mx-0 leading-relaxed break-words prevent-overflow">
                    Kalahkan rekor bermainmu hari ini. Meja terbaik kami sudah disiapkan khusus untuk kemenanganmu.
                </p>
                <div class="mt-6 md:mt-10 flex flex-col md:flex-row gap-3 md:gap-4 w-full">
                    <a href="<?php echo e(route('user.meja')); ?>" id="btn-pesan-meja" class="btn-neon mobile-full md:w-auto text-center py-3.5 px-8 rounded-xl md:rounded-2xl text-sm md:text-base">PESAN MEJA</a>
                    <a href="<?php echo e(route('user.fnb')); ?>" id="btn-menu-fnb" class="btn-ghost mobile-full md:w-auto text-center py-3.5 px-8 rounded-xl md:rounded-2xl text-sm md:text-base">MENU F&B</a>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 mb-6 md:mb-12 w-full">
            <div class="bg-[#141418]/50 border border-white/5 rounded-2xl md:rounded-[1.5rem] p-4 md:p-7 flex items-center gap-4 md:gap-5 stats-cyan transition-transform hover:-translate-y-1 w-full min-w-0">
                <div class="card-icon w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="md:w-7 md:h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <div class="min-w-0">
                    <span class="text-[0.65rem] md:text-xs font-extrabold text-white/30 uppercase tracking-[1.5px] block truncate">TOTAL BOOKING</span>
                    <span class="text-xl md:text-2xl lg:text-[1.6rem] font-black text-white block mt-0.5 truncate"><?php echo e($totalBookings); ?> MEJA</span>
                </div>
            </div>

            <div class="bg-[#141418]/50 border border-white/5 rounded-2xl md:rounded-[1.5rem] p-4 md:p-7 flex items-center gap-4 md:gap-5 stats-cyan transition-transform hover:-translate-y-1 w-full min-w-0">
                <div class="card-icon w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="md:w-7 md:h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <div class="min-w-0">
                    <span class="text-[0.65rem] md:text-xs font-extrabold text-white/30 uppercase tracking-[1.5px] block truncate">TOTAL BERMAIN</span>
                    <span class="text-xl md:text-2xl lg:text-[1.6rem] font-black text-white block mt-0.5 truncate"><?php echo e($totalHoursPlayed ?? '0'); ?> JAM</span>
                </div>
            </div>

            <div class="bg-[#141418]/50 border border-white/5 rounded-2xl md:rounded-[1.5rem] p-4 md:p-7 flex items-center gap-4 md:gap-5 stats-cyan transition-transform hover:-translate-y-1 w-full min-w-0">
                <div class="card-icon w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="md:w-7 md:h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div class="min-w-0">
                    <span class="text-[0.65rem] md:text-xs font-extrabold text-white/30 uppercase tracking-[1.5px] block truncate">BOOKING HARI INI</span>
                    <span class="text-xl md:text-2xl lg:text-[1.6rem] font-black text-white block mt-0.5 truncate"><?php echo e($activeBookingsCount); ?> MEJA</span>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-[2fr_1.2fr] gap-4 md:gap-6 lg:gap-8 w-full">

            
            <div class="bg-[#141418]/30 border border-white/5 rounded-2xl md:rounded-[2rem] p-5 md:p-9 w-full min-w-0">
                <div class="flex flex-row justify-between items-center mb-5 md:mb-6 gap-2">
                    <h3 class="text-white font-extrabold text-base md:text-xl m-0 truncate">Aktivitas Terakhir</h3>
                    <a href="<?php echo e(route('user.history')); ?>" class="text-[#00f2ff] text-xs md:text-sm font-bold no-underline hover:text-white transition-colors shrink-0">Lihat Semua</a>
                </div>
                <div class="flex flex-col w-full">
                    <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $statusText = $activity->status === 'completed' ? 'SELESAI' : ($activity->status === 'confirmed' ? 'DIPESAN' : 'BERHASIL');
                            $tableName = \App\Models\Table::find($activity->table_id)->name ?? 'Meja';
                        ?>
                        <div class="flex items-center gap-3 md:gap-4 py-3 md:py-4 border-b border-white/5 last:border-0 w-full min-w-0">
                            <div class="w-2.5 h-2.5 rounded-full bg-[#00f2ff] shadow-[0_0_10px_#00f2ff] shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <span class="text-white font-bold block text-sm md:text-base truncate">Booking <?php echo e(strtoupper($tableName)); ?></span>
                                <span class="text-white/20 text-[0.65rem] md:text-sm truncate block"><?php echo e(\Carbon\Carbon::parse($activity->booking_date)->format('d M Y')); ?>, <?php echo e(\Carbon\Carbon::parse($activity->start_time)->format('H:i')); ?> WIB</span>
                            </div>
                            <span class="text-[0.6rem] md:text-xs font-black uppercase text-[#00f2ff] bg-[#00f2ff]/10 px-2 py-1 md:px-2.5 rounded-md border border-[#00f2ff]/20 shrink-0"><?php echo e($statusText); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-8 text-center text-white/20 text-sm">Belum ada aktivitas terbaru.</div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="bg-gradient-to-br from-[#0a0b0d] to-[#050505] border border-[#00f2ff]/30 rounded-2xl md:rounded-[2rem] p-5 md:p-10 text-white relative overflow-hidden flex flex-col justify-end min-h-[180px] md:min-h-[250px] shadow-[0_15px_35px_rgba(0,0,0,0.5)] transition-all hover:border-[#00f2ff] w-full">
                <div class="absolute -top-5 -right-5 w-40 md:w-72 h-40 md:h-72 bg-[url('../../images/cyan_ball.png')] bg-contain bg-no-repeat opacity-40 rotate-12 pointer-events-none"></div>
                <div class="absolute top-4 md:top-6 left-4 md:left-6 bg-[#00f2ff]/10 text-[#00f2ff] border border-[#00f2ff]/30 px-3 py-1.5 rounded-lg text-[0.55rem] md:text-[0.65rem] font-black tracking-wider">HOT DEAL</div>
                <div class="relative z-10 mt-10 md:mt-0 w-full min-w-0">
                    <h4 class="text-[#00f2ff] text-lg md:text-[1.8rem] font-black mb-1.5 md:mb-2 leading-tight drop-shadow-[0_0_10px_rgba(0,242,255,0.3)] truncate">LET’S PLAY BILLIARD!</h4>
                    <p class="text-white/60 text-[0.8rem] md:text-[0.95rem] leading-relaxed break-words">Rasakan sensasi bermain billiard dengan suasana modern dan nyaman di Jays Billiard.</p>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnMeja = document.getElementById('btn-pesan-meja');
            const btnFnb = document.getElementById('btn-menu-fnb');

            function setActive(activeId) {
                if (activeId === 'fnb') {
                    btnMeja.classList.remove('btn-neon');
                    btnMeja.classList.add('btn-ghost');
                    btnFnb.classList.remove('btn-ghost');
                    btnFnb.classList.add('btn-neon');
                } else {
                    btnMeja.classList.remove('btn-ghost');
                    btnMeja.classList.add('btn-neon');
                    btnFnb.classList.remove('btn-neon');
                    btnFnb.classList.add('btn-ghost');
                }
            }

            const savedState = localStorage.getItem('dashboard_active_tab');
            if (savedState) { setActive(savedState); }

            btnMeja.addEventListener('click', function () { localStorage.setItem('dashboard_active_tab', 'meja'); });
            btnFnb.addEventListener('click', function () { localStorage.setItem('dashboard_active_tab', 'fnb'); });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/dashboard_user/dashboard.blade.php ENDPATH**/ ?>