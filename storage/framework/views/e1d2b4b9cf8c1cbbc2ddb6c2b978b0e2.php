<?php $__env->startSection('title', "Riwayat Pesanan — Jay's Billiard"); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/css_page/dashboard_user.css')); ?>">
    <style>
        .history-container {
            padding: 24px;
        }
        .history-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        .history-table {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
        }
        .history-table th {
            text-align: left;
            padding: 16px;
            background: rgba(0, 229, 255, 0.1);
            color: #00e5ff;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .history-table td {
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 15px;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-confirmed {
            background: rgba(0, 229, 255, 0.15);
            color: #00e5ff;
            border: 1px solid rgba(0, 229, 255, 0.3);
        }
        .status-completed {
            background: rgba(46, 213, 115, 0.15);
            color: #2ed573;
            border: 1px solid rgba(46, 213, 115, 0.3);
        }
        .status-pending {
            background: rgba(255, 171, 0, 0.15);
            color: #ffab00;
            border: 1px solid rgba(255, 171, 0, 0.3);
        }
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: rgba(255, 255, 255, 0.4);
        }
        .empty-state svg {
            margin-bottom: 16px;
            opacity: 0.2;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="history-container">
        <div class="history-card">
            <?php if($bookings->count() > 0): ?>
                <div style="overflow-x: auto;">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Meja</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td style="font-weight: 600; color: #00e5ff;"><?php echo e(strtoupper($booking->table->name ?? 'Meja')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('d M Y')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($booking->end_time)->format('H:i')); ?></td>
                                    <td>Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo e($booking->status); ?>">
                                            <?php echo e($booking->status === 'confirmed' ? 'DIPESAN' : ($booking->status === 'completed' ? 'SELESAI' : strtoupper($booking->status))); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <p>Belum ada riwayat pemesanan.</p>
                    <a href="<?php echo e(route('user.meja')); ?>" class="btn-neon" style="margin-top: 20px; display: inline-block; text-decoration: none;">PESAN SEKARANG</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/dashboard_user/history.blade.php ENDPATH**/ ?>