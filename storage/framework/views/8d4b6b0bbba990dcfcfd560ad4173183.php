<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo e(Request::is('admin*') ? 'Admin Dashboard' : 'Dashboard'); ?> — Jay's Billiard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('css/css_layout/app_admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/css_page/css_interaksi component/option_dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/css_page/css_interaksi component/akhiri.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/css_page/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/css_page/css_interaksi component/chat.css')); ?>">
</head>

<body>
    <div class="adm-layout">

        <?php if(Request::is('admin*')): ?>
            <?php echo $__env->make('component.c_dashboard.sidebar.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('component.c_dashboard.sidebar.sidebar_user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        
        <main class="adm-main">

            
            <?php echo $__env->make('component.c_dashboard.topbar.topbar', [
                'topbar_title' => 'Dashboard',
                'topbar_sub' => "Kelola kebutuhan operasional jay's billiard"
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            
            <div class="adm-content">

                
                <div class="adm-stats">
                    
                    <div class="adm-stat-card">
                                                                      

                        <div class="adm-stat-header">
                             <div class="adm-stat-icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="22" height ="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/>
                                    <path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/>
                                    <path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/>
                                </svg>

                                   
                                     
                                                            </div>

                        </div>
                        <span class="adm-stat-label">PENDAPATAN HARI INI</span>
                        <span class="adm-stat-value">IDR <?php echo e(number_format($pendapatanHariIni, 0, ',', '.')); ?></span>
                    </div>

                    
                    <div class="adm-stat-card">

                                   
                                                           <div class="adm-s
    t                                   at-header">
                             <div class="adm-stat-icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                                    <path d="M9 2h6v4H9z"/>
                                </svg>
                                   
                                     
                                
                            </div>

                        </div>
                        <span class="adm-stat-label">TOTAL PEMESANAN</span>
                        <span class="adm-stat-value"><?php echo e($totalPemesanan); ?> X</span>
                    </div>

                    
                    <div class="adm-stat-card">

                                   
                                                           <div class="adm-stat-header">
                             <div class="adm-stat-icon ">
                                <svg xmlns="http://www .w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="7" width="20" height="4" rx="1"/>
                                    <path d="M4 11v7"/>
                                    <path d="M20 11v7"/>
                                </svg>
                            </div>
                        </div>
                        <span class="adm-stat-label">TOTAL MEJA</span>
                        <span class="adm-stat-value"><?php echo e($tables->count()); ?></span>
                    </div>
                </div>


                
                <section class="adm-meja-section">
                    <div class="adm-meja-header">

                                   
                                                           <div class="adm-meja-title-group">

                                                                <div class="adm-stat-icon" style="background: rgba(0, 2
                                    09, 255, 0.1); color: #00d1ff;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <h2 class="adm-meja-title">Status Meja</h2>

                                                       </div>

                                                       <div class="adm-meja-legend">

                                                           <div class="adm-legend-item"><span class="adm-legend-dot adm-legend-dot--terisi"></span> TERISI</div>
                            <div class="adm-legend-item"><span class="adm-legend-dot adm-legend-dot--dipesan"></span> DIPESAN</div>
                            <div class="adm-legend-item"><span class="adm-legend-dot adm-legend-dot--tersedia"></span> TERSEDIA</div>
                        </div>
                    </div>

                    <div class="adm-meja-grid">
                        <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                // Logic to determine status based on active booking
                                $activeBooking = $table->bookings->first();
                                $statusClass = 'tersedia';
                                $statusLabel = 'TERSEDIA';

                                if ($activeBooking) {
                                    if ($activeBooking->status === 'confirmed') {
                                        $statusClass = 'terisi';
                                        $statusLabel = 'TERISI';
                                    } elseif ($activeBooking->status === 'pending' || $activeBooking->status === 'booked' || $activeBooking->status === 'dipesan') {
                                        $statusClass = 'dipesan';
                                        $statusLabel = 'DIPESAN';
                                    }
                                }

                                // Dynamic Time Calculation for all tables
                                $elapsedTime = '00:00:00';
                                $remainingTime = '00:00:00';
                                if ($activeBooking && $activeBooking->status === 'confirmed') {
                                    try {
                                        $baseDate = \Carbon\Carbon::parse($activeBooking->booking_date)->format('Y-m-d');
                                        $start = \Carbon\Carbon::parse($baseDate . ' ' . $activeBooking->start_time);
                                        $end = \Carbon\Carbon::parse($baseDate . ' ' . $activeBooking->end_time);
                                        if ($end->lt($start)) { $end->addDay(); }
                                        $now = \Carbon\Carbon::now();
                                        
                                        if ($now->gt($start)) {
                                            $diff = $start->diff($now);
                                            $elapsedTime = sprintf('%02d:%02d:%02d', ($diff->days * 24) + $diff->h, $diff->i, $diff->s);
                                        }
                                        
                                        if ($end->gt($now)) {
                                            $diffRem = $now->diff($end);
                                            $remainingTime = sprintf('%02d:%02d:%02d', ($diffRem->days * 24) + $diffRem->h, $diffRem->i, $diffRem->s);
                                        } else {
                                            $remainingTime = '00:00:00';
                                        }
                                    } catch (\Exception $e) {
                                        // Silent fallback
                                    }
                                }
                            ?>

                            <div class="adm-meja-card adm-meja--<?php echo e($statusClass); ?>">
                                <div class="adm-meja-card-top">
                                    <div class="adm-meja-name-wrap">
                                        <h3 class="adm-meja-name"><?php echo e(strtoupper($table->name)); ?></h3>
                                        <div class="adm-meja-status">
                                            <span class="status-dot-sm"></span> <?php echo e($statusLabel); ?>

                                        </div>
                                    </div>
                                    <div class="adm-ball-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <circle cx="12" cy="12" r="1"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="adm-meja-card-body">
                                    <div class="adm-info-box">
                                        <?php if($activeBooking && $statusClass !== 'tersedia'): ?>
                                            <?php if($statusClass === 'terisi'): ?>
                                                <div class="adm-info-row" style="margin-bottom: 0.5rem;">
                                                    <span class="adm-label">PEMAIN</span>
                                                    <span class="adm-value" style="color: #00d1ff;"><?php echo e($activeBooking->customer_name); ?></span>
                                                </div>
                                                <div class="adm-timer-container">
                                                    <div class="adm-timer-group">
                                                        <span class="adm-timer-label">SISA WAKTU</span>
                                                        <div class="adm-timer-display timer-remaining" 
                                                             data-end="<?php echo e(\Carbon\Carbon::parse($baseDate . ' ' . $activeBooking->end_time)->lt(\Carbon\Carbon::parse($baseDate . ' ' . $activeBooking->start_time)) ? \Carbon\Carbon::parse($baseDate . ' ' . $activeBooking->end_time)->addDay()->toIso8601String() : \Carbon\Carbon::parse($baseDate . ' ' . $activeBooking->end_time)->toIso8601String()); ?>">
                                                             <?php echo e($remainingTime); ?>

                                                        </div>
                                                    </div>
                                                    <div class="adm-timer-group">
                                                        <span class="adm-timer-label">WAKTU BERLALU</span>
                                                        <div class="adm-timer-display timer-elapsed" 
                                                             data-start="<?php echo e(\Carbon\Carbon::parse($baseDate . ' ' . $activeBooking->start_time)->toIso8601String()); ?>"
                                                             data-duration="<?php echo e(\Carbon\Carbon::parse($activeBooking->start_time)->diffInSeconds(\Carbon\Carbon::parse($activeBooking->end_time))); ?>">
                                                             <?php echo e($elapsedTime); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="adm-info-row"><span class="adm-label">DIPESAN OLEH</span><span class="adm-value"><?php echo e($activeBooking->customer_name); ?></span></div>
                                                <div class="adm-info-row"><span class="adm-label">DURASI</span><span class="adm-value"><?php echo e(\Carbon\Carbon::parse($activeBooking->start_time)->diffInHours(\Carbon\Carbon::parse($activeBooking->end_time))); ?> Jam</span></div>
                                                 <div class="adm-info-row"><span class="adm-label">MAIN JAM</span><span class="adm-value">
                                                     <?php echo e(\Carbon\Carbon::parse($activeBooking->start_time)->format('H:i')); ?>

                                                     <?php if($activeBooking->booking_date !== \Carbon\Carbon::now('Asia/Jakarta')->toDateString()): ?>
                                                         (<?php echo e(\Carbon\Carbon::parse($activeBooking->booking_date)->translatedFormat('d M')); ?>)
                                                     <?php endif; ?>
                                                 </span></div>
                                                <div style="margin-top: auto;">
                                                    <div class="adm-info-row"><span class="adm-label">DIPESAN JAM</span><span class="adm-value"><?php echo e($activeBooking->created_at->format('H:i')); ?></span></div>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="adm-info-empty">TIDAK ADA PEMAIN</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="adm-meja-card-footer">
                                    <?php if($statusClass === 'terisi'): ?>
                                        <button type="button" class="btn-akhiri trigger-end-session" 
                                                data-id="<?php echo e($activeBooking->id); ?>" 
                                                data-table="<?php echo e($table->name); ?>"
                                                data-duration="<?php echo e($activeBooking->duration ?? '2 Jam'); ?>"
                                                data-elapsed="<?php echo e($elapsedTime); ?>">AKHIRI SESI</button>
                                        <form id="end-session-form-<?php echo e($activeBooking->id); ?>" action="<?php echo e(route('admin.booking.end', $activeBooking->id)); ?>" method="POST" style="display:none">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    <?php elseif($statusClass === 'dipesan'): ?>
                                        <div style="display: flex; gap: 8px; width: 100%;">
                                            <form action="<?php echo e(route('admin.booking.confirm', $activeBooking->id)); ?>" method="POST" style="flex: 1;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn-konfirmasi" onclick="return confirmAction(this.form, '<?php echo e($activeBooking->customer_name); ?>', 'konfirmasi')">KONFIRMASI</button>
                                            </form>
                                            <form action="<?php echo e(route('admin.booking.cancel', $activeBooking->id)); ?>" method="POST" style="flex: 1;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn-batal" onclick="return confirmAction(this.form, '<?php echo e($activeBooking->customer_name); ?>', 'batal')">BATAL</button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <div style="flex:1"></div>
                                    <?php endif; ?>
                                    <div class="btn-chat-icon adm-btn-chat" data-meja="<?php echo e($table->id); ?>">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                        <?php if($activeBooking && in_array($activeBooking->status, ['pending', 'booked'])): ?>
                                            <span class="notif-badge">!</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>
            </div>
        </main>

    </div>

    
    <?php echo $__env->make('component.c_dashboard.modal.akhiri_sesi', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('component.c_dashboard.modal.chat_blade', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('component.c_dashboard.modal.logout_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script src="<?php echo e(asset('js/js_component/logout.js')); ?>"></script>
<script src="<?php echo e(asset('js/js_component/chat.js')); ?>"></script>
    <script src="<?php echo e(asset('js/js_component/akhiri.js')); ?>"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmAction(form, customerName, type) {
            const isConfirm = type === 'konfirmasi';
            Swal.fire({
                title: isConfirm ? 'Konfirmasi Pesanan' : 'Batalkan Pesanan',
                html: isConfirm 
                    ? `Apakah Anda yakin ingin mengkonfirmasi pesanan <b>${customerName}</b>? <br><span style="font-size: 0.85rem; color: #8a8a98; margin-top: 10px; display: block;">Meja akan ditandai sebagai Terisi dan sesi permainan akan dimulai.</span>`
                    : `Apakah Anda yakin ingin membatalkan pesanan <b>${customerName}</b>? <br><span style="font-size: 0.85rem; color: #8a8a98; margin-top: 10px; display: block;">Meja akan kembali menjadi tersedia.</span>`,
                icon: isConfirm ? 'info' : 'warning',
                iconColor: isConfirm ? '#00e5ff' : '#ff3b3b',
                showCancelButton: true,
                confirmButtonText: isConfirm ? 'KONFIRMASI' : 'BATALKAN',
                cancelButtonText: 'KEMBALI',
                background: '#111418',
                color: '#fff',
                confirmButtonColor: isConfirm ? '#00e5ff' : '#ff3b3b',
                cancelButtonColor: 'transparent',
                didOpen: () => {
                    const title = document.querySelector('.swal2-title');
                    const content = document.querySelector('.swal2-html-container');
                    if(title) title.style.textAlign = 'left';
                    if(content) content.style.textAlign = 'left';
                    
                    const cancelBtn = document.querySelector('.swal2-cancel');
                    if(cancelBtn) {
                        cancelBtn.style.fontWeight = '800';
                        cancelBtn.style.color = '#8a8a98';
                    }
                    
                    const confirmBtn = document.querySelector('.swal2-confirm');
                    if(confirmBtn) {
                        confirmBtn.style.fontWeight = '800';
                        confirmBtn.style.color = '#000';
                        confirmBtn.style.borderRadius = '10px';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }

        // Auto refresh page every 30 seconds to simulate real-time updates
        setTimeout(function() {
            window.location.reload();
        }, 30000);
    </script>
    <script>
        // Real-time Timer Logic
        function updateTimers() {
            const now = new Date();

            // Update Elapsed Timers (Capped at Duration)
            document.querySelectorAll('.timer-elapsed').forEach(el => {
                const startStr = el.dataset.start;
                const durationSeconds = parseInt(el.dataset.duration);
                if (!startStr || isNaN(durationSeconds)) return;

                const startTime = new Date(startStr);
                if (isNaN(startTime.getTime())) return;

                let diffMs = now - startTime;
                let diffSeconds = Math.floor(diffMs / 1000);

                // Cap at duration
                if (diffSeconds > durationSeconds) {
                    diffSeconds = durationSeconds;
                    el.style.color = "#8a8a98";
                }

                if (diffSeconds >= 0) {
                    el.textContent = formatSeconds(diffSeconds);
                }
            });

            // Update Remaining Timers
            document.querySelectorAll('.timer-remaining').forEach(el => {
                const endStr = el.dataset.end;
                if (!endStr) return;

                const endTime = new Date(endStr);
                if (isNaN(endTime.getTime())) return;

                const diffMs = endTime - now;
                if (diffMs > 0) {
                    el.textContent = formatSeconds(Math.floor(diffMs / 1000));
                } else {
                    el.textContent = "00:00:00";
                    el.style.color = "#ff3b3b";
                }
            });
        }

        function formatSeconds(totalSeconds) {
            if (totalSeconds < 0) totalSeconds = 0;
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        setInterval(updateTimers, 1000);
        updateTimers(); 
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/dashboard_admin/dashboard.blade.php ENDPATH**/ ?>