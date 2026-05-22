<?php $__env->startSection('title', "Dashboard — Jay's Billiard"); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/css_page/dashboard_user.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="user-dashboard-container">

        
        <div class="welcome-hero">
            <div class="hero-content">
                <h1>Halo, <?php echo e(Auth::user()->name); ?>! </h1>
                <p>Rasakan sensasi bermain billiard dengan suasana modern dan nyaman di Jays Billiard.</p>
                <div class="hero-actions">
                    <a href="<?php echo e(route('user.meja')); ?>" id="btn-pesan-meja" class="btn-neon">PESAN MEJA</a>
                    <a href="<?php echo e(route('user.fnb')); ?>" id="btn-menu-fnb" class="btn-ghost">MENU F&B</a>
                </div>
            </div>
            
        </div>

        
        <div class="user-stats-grid">
            <div class="user-card stats-cyan">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <div class="card-info">
                    <span class="user-card-label">TOTAL BOOKING</span>
                    <span class="user-card-title" id="valTotalBooking"><?php echo e($totalBookings); ?> MEJA</span>
                </div>
            </div>

            <div class="user-card stats-cyan">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div class="card-info">
                    <span class="user-card-label">BOOKING HARI INI</span>
                    <span class="user-card-title"><?php echo e($activeBookingsCount); ?> MEJA</span>
                </div>
            </div>

        </div>

        
        <div class="dashboard-bottom-grid">

            
            <div class="recent-activity-card">
                <div class="card-header">
                    <h3>Aktivitas Terakhir</h3>
                    <a href="<?php echo e(route('user.history')); ?>">Lihat Semua</a>
                </div>
                <div class="activity-list" id="activityList">
                    <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $statusText = $activity->status === 'completed' ? 'SELESAI' : ($activity->status === 'confirmed' ? 'DIPESAN' : 'BERHASIL');
                            // Getting table name
                            $tableName = \App\Models\Table::find($activity->table_id)->name ?? 'Meja';
                        ?>
                        <div class="activity-item">
                            <div class="act-icon dot-cyan"></div>
                            <div class="act-info">
                                <span class="act-name">Booking <?php echo e(strtoupper($tableName)); ?></span>
                                <span class="act-date"><?php echo e(\Carbon\Carbon::parse($activity->booking_date)->format('d M Y')); ?>,
                                    <?php echo e(\Carbon\Carbon::parse($activity->start_time)->format('H:i')); ?> WIB</span>
                            </div>
                            <span class="act-status success"><?php echo e($statusText); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div style="padding: 20px; text-align: center; color: rgba(255,255,255,0.2);">Belum ada aktivitas
                            terbaru.</div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="promo-banner-card">
                <div class="promo-badge">HOT DEAL</div>
                <div class="promo-content">
                    <h4>LET’S PLAY BILLIARD!</h4>
                    <p>Rasakan sensasi bermain billiard dengan suasana modern dan nyaman di Jays Billiard.</p>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Stats Management
            // Tabs toggle logic
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