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

        <div class="payment-details-section" style="margin-top: 30px;">
            <div class="detail-section-title" id="dynamic-payment-title" style="font-size: 0.85rem; font-weight: 800; color: #fff; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 1px;">QRIS VIA MIDTRANS</div>
            <div class="detail-section-content" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--card-border); border-radius: 16px; padding: 20px; text-align: left; display: flex; flex-direction: column; gap: 15px; min-height: auto;">
                <div style="display: flex; gap: 15px; align-items: flex-start;">
                    <div id="dynamic-payment-icon-box" style="width: 44px; height: 44px; background: #00aaff; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <span id="dynamic-payment-icon-text" style="color: #fff; font-weight: 900; font-size: 0.9rem;">QR</span>
                    </div>
                    <div>
                        <div id="dynamic-payment-name" style="color: #fff; font-weight: 800; font-size: 0.95rem; margin-bottom: 5px;">QRIS Dinamis</div>
                        <div id="dynamic-payment-desc" style="color: var(--text-muted); font-size: 0.8rem; line-height: 1.5;">Snap Midtrans akan membuka kode QRIS yang bisa dibayar lewat aplikasi bank atau e-wallet.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="payment-main-area">
        <div class="timer-card">
            <div class="timer-icon" style="background: rgba(0, 242, 255, 0.08); border-radius: 12px; width: 44px; height: 44px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <div class="timer-info" id="timer-status-wrapper">
                <div class="timer-label" id="payment-status-text">Batas Waktu Pembayaran</div>
                <div class="timer-sub" id="payment-status-sub">Selesaikan pembayaran melalui Midtrans Snap</div>
            </div>
            <div class="countdown-display">
                <div class="time-unit">
                    <div class="time-box">0</div>
                    <div class="time-label">HRS</div>
                </div>
                <div class="time-dots">:</div>
                <div class="time-unit">
                    <div class="time-box">14</div>
                    <div class="time-label">MIN</div>
                </div>
                <div class="time-dots">:</div>
                <div class="time-unit">
                    <div class="time-box">2</div>
                    <div class="time-label">SEC</div>
                </div>
            </div>
        </div>

        <div class="methods-card">
            <div class="category-header" style="margin-bottom: 24px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                <span style="font-size: 1.1rem;">Pilih Metode Pembayaran</span>
            </div>

            <div class="method-list" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <!-- QRIS -->
                <div class="method-option selected" id="method-qris">
                    <div class="option-left">
                        <div class="method-icon-box" style="background: #00aaff;">
                            <span style="color: #fff; font-weight: 900; font-size: 0.9rem;">QR</span>
                        </div>
                        <div class="method-text">
                            <div class="option-name">QRIS</div>
                            <div class="option-sub">Scan dari bank atau e-wallet</div>
                        </div>
                    </div>
                    <div class="radio-circle"></div>
                </div>

                <!-- DANA -->
                <div class="method-option" id="method-dana">
                    <div class="option-left">
                        <div class="method-icon-box" style="background: #118ee0;">
                            <span style="color: #fff; font-weight: 900; font-size: 0.75rem;">DANA</span>
                        </div>
                        <div class="method-text">
                            <div class="option-name">DANA</div>
                            <div class="option-sub">Redirect ke pembayaran DANA</div>
                        </div>
                    </div>
                    <div class="radio-circle"></div>
                </div>

                <!-- GoPay -->
                <div class="method-option" id="method-gopay">
                    <div class="option-left">
                        <div class="method-icon-box" style="background: #00c853;">
                            <span style="color: #fff; font-weight: 900; font-size: 0.85rem;">GP</span>
                        </div>
                        <div class="method-text">
                            <div class="option-name">GoPay</div>
                            <div class="option-sub">Deeplink atau scan QR</div>
                        </div>
                    </div>
                    <div class="radio-circle"></div>
                </div>
            </div>

            <div class="method-info-text" style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5; margin-top: 24px; margin-bottom: 24px; text-align: left;">
                QRIS dan GoPay diproses lewat Midtrans Snap. DANA redirect memakai Snap-BI Direct Debit jika credential tersedia.
            </div>

            <div class="konfirmasi-footer" style="width: 100%; display: flex; justify-content: flex-end; align-items: center; gap: 24px;">
                <a href="<?php echo e(route('user.fnb')); ?>" class="cancel-link" id="cancel-btn" style="font-size: 1rem; font-weight: 700; color: var(--text-muted); text-decoration: none; transition: color 0.2s;">Cancel</a>
                <button class="pay-btn" id="main-pay-btn" style="padding: 16px 32px; font-size: 1.1rem; font-weight: 900; border-radius: 14px; text-transform: none;">Bayar QRIS via Midtrans</button>
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
        const methodOptions = document.querySelectorAll('.method-option');
        const mainPayBtn = document.getElementById('main-pay-btn');
        const paymentStatusText = document.getElementById('payment-status-text');
        const paymentStatusSub = document.getElementById('payment-status-sub');
        const cancelBtn = document.getElementById('cancel-btn');
        const itemsList = document.getElementById('konfirmasi-items-list');

        // Interactive method selection
        methodOptions.forEach(option => {
            option.addEventListener('click', function() {
                methodOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                
                const methodName = this.querySelector('.option-name').innerText;
                const dynTitle = document.getElementById('dynamic-payment-title');
                const dynIconBox = document.getElementById('dynamic-payment-icon-box');
                const dynIconText = document.getElementById('dynamic-payment-icon-text');
                const dynName = document.getElementById('dynamic-payment-name');
                const dynDesc = document.getElementById('dynamic-payment-desc');

                if (methodName === 'QRIS') {
                    mainPayBtn.innerText = 'Bayar QRIS via Midtrans';
                    dynTitle.innerText = 'QRIS VIA MIDTRANS';
                    dynIconBox.style.background = '#00aaff';
                    dynIconText.innerText = 'QR';
                    dynIconText.style.fontSize = '0.9rem';
                    dynName.innerText = 'QRIS Dinamis';
                    dynDesc.innerText = 'Snap Midtrans akan membuka kode QRIS yang bisa dibayar lewat aplikasi bank atau e-wallet.';
                } else if (methodName === 'DANA') {
                    mainPayBtn.innerText = 'Bayar DANA via Midtrans';
                    dynTitle.innerText = 'DANA VIA MIDTRANS';
                    dynIconBox.style.background = '#118ee0';
                    dynIconText.innerText = 'DANA';
                    dynIconText.style.fontSize = '0.65rem';
                    dynName.innerText = 'DANA';
                    dynDesc.innerText = 'Pembayaran akan diarahkan ke aplikasi DANA. Pastikan saldo Anda mencukupi.';
                } else if (methodName === 'GoPay') {
                    mainPayBtn.innerText = 'Bayar GoPay via Midtrans';
                    dynTitle.innerText = 'GOPAY VIA MIDTRANS';
                    dynIconBox.style.background = '#00c853';
                    dynIconText.innerText = 'GP';
                    dynIconText.style.fontSize = '0.85rem';
                    dynName.innerText = 'GoPay';
                    dynDesc.innerText = 'Buka aplikasi Gojek untuk memindai kode QR, atau selesaikan pembayaran lewat deeplink.';
                } else {
                    mainPayBtn.innerText = 'Bayar via Midtrans';
                }
            });
        });

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
                        showAlert('info', 'Menunggu Pembayaran', 'Ikuti instruksi pembayaran dari Midtrans.');
                    },
                    onError: function() {
                        showAlert('error', 'Pembayaran Gagal', 'Silakan coba lagi atau pilih metode lain di Midtrans.');
                    },
                    onClose: function() {
                        mainPayBtn.disabled = false;
                        mainPayBtn.innerText = 'Bayar Sekarang';
                    }
                });
            })
            .catch(err => {
                console.error(err);
                showAlert('error', 'Terjadi Kesalahan', err.message || 'Sistem belum bisa memproses pembayaran.');
            })
            .finally(() => {
                // If snap popup closes immediately due to error, we might want to re-enable button
                // But Midtrans Snap handles it inside onClose.
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