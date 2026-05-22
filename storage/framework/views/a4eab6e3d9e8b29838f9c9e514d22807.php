<?php $__env->startSection('title', 'Konfirmasi Pembayaran Makanan & Minuman'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/css_page/konfirmasi_pembayaran.css')); ?>">
    <style>
        .antarkan-title {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .antarkan-meja {
            color: #fff;
            font-weight: 800;
        }

        .items-list-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .fnb-item-preview {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .fnb-item-img {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
        }

        .fnb-item-info {
            flex: 1;
            min-width: 0;
        }

        .fnb-item-name-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 2px;
        }

        .fnb-item-name {
            font-size: 0.95rem;
            font-weight: 800;
            color: #fff;
            word-break: break-word;
        }

        .fnb-item-qty {
            font-size: 0.9rem;
            color: #fff;
            font-weight: 800;
            white-space: nowrap;
        }

        .fnb-item-meta {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .fnb-item-price {
            font-size: 0.9rem;
            font-weight: 800;
            color: #fff;
            white-space: nowrap;
        }

        .total-amount-block {
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .total-amount-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .total-amount-value {
            font-size: 2.2rem;
            font-weight: 900;
            color: var(--primary-cyan);
        }

        .midtrans-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 32px;
            padding: 32px;
        }

        .midtrans-card__icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: rgba(0, 242, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-cyan);
            margin-bottom: 22px;
        }

        .midtrans-card__title {
            font-size: 1.35rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 10px;
        }

        .midtrans-card__text {
            max-width: 620px;
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .midtrans-status {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 30px;
        }

        .midtrans-status__item {
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            padding: 18px;
        }

        .midtrans-status__label {
            color: var(--text-muted);
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .midtrans-status__value {
            color: #fff;
            font-size: 0.95rem;
            font-weight: 800;
        }

        .pay-btn[disabled] {
            cursor: wait;
            opacity: 0.7;
            transform: none;
        }

        @media (max-width: 900px) {
            .midtrans-status {
                grid-template-columns: 1fr;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="konfirmasi-wrapper">
    <div class="summary-container">
        <h3 class="summary-title">Ringkasan Pemesanan</h3>

        <div class="antarkan-title">
            Antarkan ke Meja <span class="antarkan-meja">-</span>
        </div>

        <div class="items-list-container" id="konfirmasi-items-list">
            <div style="color: var(--text-muted); font-weight: 700;">Memuat pesanan...</div>
        </div>

        <div class="price-breakdown">
            <div class="breakdown-row">
                <span>Subtotal</span>
                <span class="detail-value" id="konfirmasi-subtotal">Rp 0</span>
            </div>
            <div class="breakdown-row">
                <span>Service & Tax (10%)</span>
                <span class="detail-value" id="konfirmasi-tax">Rp 0</span>
            </div>

            <div class="total-amount-block">
                <div class="total-amount-label">Total Amount</div>
                <div class="total-amount-value" id="konfirmasi-total">Rp 0</div>
            </div>
        </div>
    </div>

    <div class="payment-main-area">
        <div class="timer-card">
            <div class="timer-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="M20 12h2"></path><path d="M2 12h2"></path></svg>
            </div>
            <div class="timer-info" id="timer-status-wrapper">
                <div class="timer-label" id="payment-status-text">Batas Waktu Pembayaran</div>
                <div class="timer-sub" id="payment-status-sub">Selesaikan pembayaran melalui Midtrans</div>
            </div>
            <div class="countdown-display">
                <div class="time-unit">
                    <div class="time-box">0</div>
                    <div class="time-label">HRS</div>
                </div>
                <div class="time-dots">:</div>
                <div class="time-unit">
                    <div class="time-box">22</div>
                    <div class="time-label">MIN</div>
                </div>
                <div class="time-dots">:</div>
                <div class="time-unit">
                    <div class="time-box">30</div>
                    <div class="time-label">SEC</div>
                </div>
            </div>
        </div>

        <div class="midtrans-card">
            <div class="midtrans-card__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
            </div>
            <h3 class="midtrans-card__title">Pembayaran Midtrans</h3>
            <p class="midtrans-card__text">
                Semua metode pembayaran diproses langsung oleh Midtrans. Pilihan QRIS, virtual account, kartu, atau e-wallet akan tampil di popup resmi Midtrans setelah tombol bayar ditekan.
            </p>

            <div class="midtrans-status">
                <div class="midtrans-status__item">
                    <div class="midtrans-status__label">Gateway</div>
                    <div class="midtrans-status__value">Midtrans Snap</div>
                </div>
                <div class="midtrans-status__item">
                    <div class="midtrans-status__label">Mode</div>
                    <div class="midtrans-status__value"><?php echo e(config('services.midtrans.is_production') ? 'Production' : 'Sandbox'); ?></div>
                </div>
                <div class="midtrans-status__item">
                    <div class="midtrans-status__label">Status</div>
                    <div class="midtrans-status__value" id="snap-status">Menunggu pembayaran</div>
                </div>
            </div>

            <div class="konfirmasi-footer">
                <a href="<?php echo e(route('user.fnb')); ?>" class="cancel-link" id="cancel-btn">Cancel</a>
                <button class="pay-btn" id="main-pay-btn">Bayar dengan Midtrans</button>
            </div>
        </div>
    </div>
</div>

<div class="success-overlay" id="success-overlay">
    <div class="success-modal">
        <div class="success-icon-wrap">
            <div class="success-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
        </div>

        <h2 class="success-title">Pembayaran Berhasil!</h2>
        <p class="success-sub">Transaksi Anda telah berhasil diproses oleh Midtrans</p>

        <div class="receipt-card">
            <div class="receipt-row">
                <span class="receipt-label">TOTAL PEMBAYARAN</span>
                <span class="receipt-value cyan" id="modal-total-value">Rp 0</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">METODE PEMBAYARAN</span>
                <span class="receipt-value white" id="final-method-name">Midtrans</span>
            </div>
        </div>

        <p class="success-note">
            Terima kasih! Pesanan Anda segera disiapkan dan akan diantar ke meja dalam kurun waktu 15 - 20 menit.
        </p>

        <div class="success-actions">
            <a href="<?php echo e(route('user.fnb')); ?>" class="btn-kembali">Kembali</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js'); ?>" data-client-key="<?php echo e(config('services.midtrans.client_key')); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mainPayBtn = document.getElementById('main-pay-btn');
        const paymentStatusText = document.getElementById('payment-status-text');
        const paymentStatusSub = document.getElementById('payment-status-sub');
        const snapStatus = document.getElementById('snap-status');
        const cancelBtn = document.getElementById('cancel-btn');
        const itemsList = document.getElementById('konfirmasi-items-list');

        const orderDataRaw = localStorage.getItem('fnb_order');
        let orderData = null;

        function formatRupiah(value) {
            return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
        }

        function escapeHtml(value) {
            return String(value || '').replace(/[&<>"']/g, function (char) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[char];
            });
        }

        function setPayLoading(isLoading) {
            mainPayBtn.disabled = isLoading;
            mainPayBtn.innerText = isLoading ? 'Memproses...' : 'Bayar dengan Midtrans';
        }

        function showAlert(icon, title, text) {
            Swal.fire({
                icon,
                title,
                text,
                background: '#141418',
                color: '#fff'
            });
        }

        if (orderDataRaw) {
            try {
                orderData = JSON.parse(orderDataRaw);
            } catch (error) {
                orderData = null;
            }
        }

        if (!orderData || !Array.isArray(orderData.items) || orderData.items.length === 0) {
            itemsList.innerHTML = '<div style="color: var(--text-muted); font-weight: 700;">Data pesanan tidak ditemukan.</div>';
            mainPayBtn.disabled = true;
        } else {
            document.querySelector('.antarkan-meja').innerText = orderData.tableName || '-';
            itemsList.innerHTML = '';

            orderData.items.forEach(item => {
                const priceFormatted = formatRupiah(Number(item.price || 0) * Number(item.quantity || 0));
                const html = `
                    <div class="fnb-item-preview">
                        <img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}" class="fnb-item-img" onerror="this.src='/images/hero-bg.png'">
                        <div class="fnb-item-info">
                            <div class="fnb-item-name-wrap">
                                <span class="fnb-item-name">${escapeHtml(item.name)}</span>
                                <span class="fnb-item-qty">${Number(item.quantity || 0)}x</span>
                            </div>
                            <div class="fnb-item-meta">${escapeHtml(item.category)}</div>
                        </div>
                        <div class="fnb-item-price">${priceFormatted}</div>
                    </div>
                `;
                itemsList.insertAdjacentHTML('beforeend', html);
            });

            document.getElementById('konfirmasi-subtotal').innerText = formatRupiah(orderData.subtotal);
            document.getElementById('konfirmasi-tax').innerText = formatRupiah(orderData.tax);
            document.getElementById('konfirmasi-total').innerText = formatRupiah(orderData.total);
            document.getElementById('modal-total-value').innerText = formatRupiah(orderData.total);
        }

        mainPayBtn.addEventListener('click', function() {
            if (!orderData) {
                showAlert('warning', 'Data Pesanan Kosong', 'Silakan pilih menu terlebih dahulu.');
                return;
            }

            setPayLoading(true);
            snapStatus.innerText = 'Membuka Midtrans';

            fetch('<?php echo e(route("user.fnb.checkout")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    table_id: orderData.tableId || null,
                    items: orderData.items.map(item => ({
                        id: item.id,
                        quantity: Number(item.quantity || 0)
                    }))
                })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.snap_token) {
                    throw new Error(data.message || 'Snap token tidak tersedia.');
                }

                if (data.total) {
                    orderData.subtotal = data.subtotal || orderData.subtotal;
                    orderData.tax = data.tax || orderData.tax;
                    orderData.total = data.total;
                    document.getElementById('konfirmasi-subtotal').innerText = formatRupiah(orderData.subtotal);
                    document.getElementById('konfirmasi-tax').innerText = formatRupiah(orderData.tax);
                    document.getElementById('konfirmasi-total').innerText = formatRupiah(data.total);
                    document.getElementById('modal-total-value').innerText = formatRupiah(data.total);
                }

                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        const paymentMethod = result.payment_type || 'Midtrans';
                        document.getElementById('final-method-name').innerText = paymentMethod;
                        
                        // Notify backend to reduce stock (since webhooks don't work on localhost)
                        fetch('<?php echo e(route("user.fnb.success")); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            },
                            body: JSON.stringify({ order_id: data.order_id })
                        })
                        .then(res => res.json())
                        .then(successData => {
                            console.log('Stock update response:', successData);
                        })
                        .catch(err => console.error('Stock update error:', err));

                        saveFnbHistory(orderData, paymentMethod, 'paid');
                        showFnbSuccessModal();
                    },
                    onPending: function(result) {
                        const paymentMethod = result.payment_type || 'Midtrans';
                        document.getElementById('final-method-name').innerText = paymentMethod;
                        saveFnbHistory(orderData, paymentMethod, 'pending');
                        snapStatus.innerText = 'Menunggu pembayaran';
                        showAlert('info', 'Menunggu Pembayaran', 'Ikuti instruksi pembayaran dari Midtrans.');
                    },
                    onError: function() {
                        snapStatus.innerText = 'Pembayaran gagal';
                        showAlert('error', 'Pembayaran Gagal', 'Silakan coba lagi atau pilih metode lain di Midtrans.');
                    },
                    onClose: function() {
                        snapStatus.innerText = 'Popup ditutup';
                    }
                });
            })
            .catch(err => {
                console.error(err);
                snapStatus.innerText = 'Terjadi kesalahan';
                showAlert('error', 'Terjadi Kesalahan', err.message || 'Sistem belum bisa memproses pembayaran.');
            })
            .finally(() => {
                setPayLoading(false);
            });
        });

        function saveFnbHistory(orderData, paymentMethod, status) {
            const historyData = JSON.parse(localStorage.getItem('billiard_history') || '[]');
            const newEntry = {
                id: 'FNB-' + Math.floor(Math.random() * 1000),
                customer_name: '<?php echo e(Auth::user()->name); ?>',
                tables: orderData.tableName || 'Takeaway',
                date: new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }),
                time: new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' }),
                duration: '-',
                total: formatRupiah(orderData.total),
                status,
                payment_method: paymentMethod,
                fnb: orderData.items || [],
                timestamp: new Date().getTime()
            };

            historyData.unshift(newEntry);
            localStorage.setItem('billiard_history', JSON.stringify(historyData));
        }

        function showFnbSuccessModal() {
            mainPayBtn.innerText = 'Pembayaran Selesai';
            mainPayBtn.disabled = true;
            mainPayBtn.style.background = '#00f2ff';

            snapStatus.innerText = 'Pembayaran berhasil';
            paymentStatusText.innerHTML = 'Status Pembayaran : <span style="color: #00f2ff;">BERHASIL</span>';
            paymentStatusSub.innerText = 'Pesanan segera diproses';
            cancelBtn.style.display = 'none';

            hours = 0;
            minutes = 0;
            seconds = 0;
            updateTimerBoxes();

            localStorage.removeItem('fnb_order');

            setTimeout(() => {
                document.getElementById('success-overlay').classList.add('active');
            }, 500);
        }

        let hours = 0;
        let minutes = 22;
        let seconds = 30;
        const timeBoxes = document.querySelectorAll('.time-box');

        function updateTimer() {
            if (seconds > 0) {
                seconds--;
            } else if (minutes > 0) {
                minutes--;
                seconds = 59;
            } else if (hours > 0) {
                hours--;
                minutes = 59;
                seconds = 59;
            }

            updateTimerBoxes();
        }

        function updateTimerBoxes() {
            if (timeBoxes.length >= 3) {
                timeBoxes[0].innerText = hours;
                timeBoxes[1].innerText = minutes;
                timeBoxes[2].innerText = seconds;
            }
        }

        setInterval(updateTimer, 1000);
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/dashboard_user/fnb_konfirmasi.blade.php ENDPATH**/ ?>