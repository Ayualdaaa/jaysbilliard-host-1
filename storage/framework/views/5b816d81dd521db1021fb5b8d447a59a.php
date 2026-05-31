<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok F&B — Jay's Billiard</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; color: #666; }
        
        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #000; padding-bottom: 5px; margin-top: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        
        .type-in { color: green; font-weight: bold; }
        .type-out { color: red; font-weight: bold; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN STOK MAKANAN & MINUMAN</h1>
        <p>Jay's Billiard — Tanggal Cetak: <?php echo e(date('d M Y, H:i')); ?></p>
    </div>

    <div class="section-title">STOK SAAT INI (PER ITEM)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Nama Item</th>
                <th>Kategori</th>
                <th style="text-align: right;">Stok Terakhir</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($menu->name); ?></td>
                    <td><?php echo e($menu->category); ?></td>
                    <td style="text-align: right; font-weight: bold;"><?php echo e($menu->stock); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="section-title">RIWAYAT TRANSAKSI TERAKHIR</div>
    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Item</th>
                <th>Jenis</th>
                <th style="text-align: right;">Jumlah</th>
                <th>Tanggal</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $transactions->take(50); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($transaction->menu->name); ?></td>
                    <td>
                        <span class="<?php echo e($transaction->type === 'in' ? 'type-in' : 'type-out'); ?>">
                            <?php echo e($transaction->type === 'in' ? 'MASUK' : 'KELUAR'); ?>

                        </span>
                    </td>
                    <td style="text-align: right;"><?php echo e($transaction->quantity); ?></td>
                    <td><?php echo e($transaction->created_at->format('d/m/Y H:i')); ?></td>
                    <td><?php echo e($transaction->note ?? '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="footer">
        Dicetak secara otomatis oleh Sistem Jay's Billiard Dashboard
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/dashboard_admin/stock/pdf.blade.php ENDPATH**/ ?>