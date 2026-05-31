<!DOCTYPE html>
<html>
<head>
    <title>Laporan History Pemesanan Jay's Billiard</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11pt; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #000; font-size: 22pt; }
        .header p { margin: 5px 0; font-size: 10pt; color: #666; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; font-size: 10pt; }
        td { font-size: 9pt; }
        
        .status-pill { padding: 4px 8px; border-radius: 4px; font-size: 8pt; font-weight: bold; }
        .selesai { background-color: #ffebee; color: #c62828; }
        .lunas { background-color: #e8f5e9; color: #2e7d32; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 8pt; color: #999; }
        .meja-badge { font-weight: bold; color: #00838f; }
    </style>
</head>
<body>
    <div class="header">
        <h1>JAY'S BILLIARD</h1>
        <p>Laporan Riwayat Pemesanan Meja & F&B</p>
        <p>Tanggal Cetak: <?php echo e(date('d F Y H:i')); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">ID</th>
                <th width="120">NAMA PELANGGAN</th>
                <th width="80">MEJA</th>
                <th>MAKANAN & MINUMAN</th>
                <th width="110">TANGGAL/WAKTU</th>
                <th width="60">DURASI</th>
                <th width="80">TOTAL HARGA</th>
                <th width="70">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $fnbSummary = [];
                    foreach($booking->orders as $order) {
                        foreach($order->details as $detail) {
                            if($detail->menu) {
                                $fnbSummary[] = $detail->menu->name . ' (x' . $detail->quantity . ')';
                            }
                        }
                    }
                    
                    try {
                        $start = \Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->start_time);
                        $end = \Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->end_time);
                        if ($end->lt($start)) {
                            $end->addDay();
                        }
                        $duration = $start->diffInHours($end) . ' Jam';
                    } catch (\Exception $e) {
                        $duration = '2 Jam';
                    }
                ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($booking->customer_name); ?></td>
                    <td><span class="meja-badge"><?php echo e($booking->table->name ?? '-'); ?></span></td>
                    <td><?php echo e(count($fnbSummary) > 0 ? implode(', ', $fnbSummary) : '-'); ?></td>
                    <td>
                        <?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('d M Y')); ?><br>
                        <small><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?> WIB</small>
                    </td>
                    <td><?php echo e($duration); ?></td>
                    <td>Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td>
                    <td>
                        <span class="status-pill <?php echo e(in_array(strtolower($booking->status), ['completed', 'selesai']) ? 'selesai' : 'lunas'); ?>">
                            <?php echo e(in_array(strtolower($booking->status), ['completed', 'selesai']) ? 'Selesai' : 'Lunas'); ?>

                        </span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh Sistem Jay's Billiard &bull; <?php echo e(date('Y')); ?>

    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/dashboard_admin/history_pdf.blade.php ENDPATH**/ ?>