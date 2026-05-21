<?php $__env->startSection('title', "Konfirmasi Pembayaran — Jay's Billiard"); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/css_page/konfirmasi_pembayaran.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="konfirmasi-wrapper">
        
        <div class="summary-container">
            <h3 class="summary-title">Ringkasan Pemesanan</h3>

            <div id="konfirmasi-tables-container" style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px;">
                
                <div class="table-info-card">
                    <img src="<?php echo e(asset('images/hero-bg.png')); ?>" alt="Meja" class="table-img" id="konfirmasi-img">
                    <div class="table-text">
                        <div class="table-name" id="konfirmasi-name">Pilih Meja <span class="table-capacity" id="konfirmasi-ppl">0 Orang</span></div>
                        <div class="table-type" id="konfirmasi-type">Regular</div>
                    </div>
                </div>
            </div>

            <div class="booking-details">
                <div class="detail-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <span class="detail-label">Date</span>
                    <span class="detail-value" id="konfirmasi-date">Oct 24, 2023</span>
                </div>
                <div class="detail-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span class="detail-label">Time</span>
                    <span class="detail-value" id="konfirmasi-time">19:00 - 21:00</span>
                </div>
                <div class="detail-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span class="detail-label">Duration</span>
                    <span class="detail-value" id="konfirmasi-duration">2 Hours</span>
                </div>
            </div>

            <div class="price-breakdown">
                <div class="breakdown-row">
                    <span>Subtotal</span>
                    <span id="konfirmasi-subtotal">Rp 200.000</span>
                </div>
                <div class="breakdown-row">
                    <span>Service & Tax (10%)</span>
                    <span id="konfirmasi-tax">Rp 5.000</span>
                </div>
                <div class="total-row">
                    <span style="font-size: 1.1rem; font-weight: 800; color: #fff;">Total Amount</span>
                </div>
                <div class="total-row" style="margin-top: 5px;">
                    <span class="total-value" id="konfirmasi-total">Rp 205.000</span>
                </div>
            </div>

            <div class="payment-details-section">
                <div class="detail-section-title">Status Pembayaran</div>
                <div class="detail-section-content" id="payment-method-content">
                    <div style="padding: 20px; text-align: center; color: var(--text-muted); font-size: 0.9rem;">
                        Silakan klik tombol bayar untuk memproses transaksi via Midtrans
                    </div>
                </div>
            </div>
        </div>

        
        <div class="payment-main-area">
            
            <div class="timer-card">
                <div class="timer-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="M20 12h2"></path><path d="M2 12h2"></path></svg>
                </div>
                <div class="timer-info">
                    <div class="timer-label">Batas Waktu Pembayaran</div>
                    <div class="timer-sub">Selesaikan pembayaran sebelum waktu habis</div>
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

            
            <div class="methods-card" style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 60px 40px; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 32px;">
                <div style="width: 80px; height: 80px; background: rgba(0, 242, 255, 0.1); border-radius: 24px; display: flex; align-items: center; justify-content: center; color: var(--primary-cyan); margin-bottom: 30px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                <h3 style="font-size: 1.8rem; font-weight: 900; color: #fff; margin-bottom: 12px;">Siap untuk Bermain?</h3>
                <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 500px; line-height: 1.6; margin-bottom: 45px;">
                    Klik tombol di bawah untuk menyelesaikan pembayaran. Anda dapat memilih metode pembayaran (Transfer, QRIS, dll) di halaman berikutnya.
                </p>

                <div class="konfirmasi-footer" style="width: 100%; max-width: 400px; display: flex; flex-direction: column; gap: 15px;">
                    <button class="pay-btn" id="main-pay-btn" style="width: 100%; padding: 22px; font-size: 1.2rem; font-weight: 900; border-radius: 18px; text-transform: uppercase; letter-spacing: 1px;">Bayar Sekarang</button>
                    <a href="<?php echo e(route('user.meja')); ?>" class="cancel-link" style="font-size: 1rem; font-weight: 700; color: var(--text-muted); text-decoration: none; transition: color 0.2s;">Kembali ke Pilih Meja</a>
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
            <p class="success-sub">Transaksi Anda telah berhasil diproses</p>

            <div class="receipt-card">
                <div class="receipt-row">
                    <span class="receipt-label">TOTAL PEMBAYARAN</span>
                    <span class="receipt-value cyan" id="modal-total-value">Rp 205.000</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">METODE PEMBAYARAN</span>
                    <span class="receipt-value white" id="final-method-name">QRIS</span>
                </div>
            </div>

            <p class="success-note">
                Terima kasih! Sesi meja Anda telah dikonfirmasi. Silakan tunjukkan struk digital ini ke kasir saat tiba di lokasi.
            </p>

            <div class="success-actions">
                <a href="<?php echo e(route('user.meja')); ?>" class="btn-kembali">Kembali</a>
                <button class="btn-download">Download Struk</button>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js'); ?>" data-client-key="<?php echo e(config('services.midtrans.client_key')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const methodOptions = document.querySelectorAll('.method-option');
            const methodTitle = document.getElementById('payment-method-title');
            const methodContent = document.getElementById('payment-method-content');

            // Dynamic Data Binding from localStorage
            const orderDataRaw = localStorage.getItem('meja_order');
            if(orderDataRaw) {
                const orderData = JSON.parse(orderDataRaw);

                // Multi Table Info Render
                const tablesContainer = document.getElementById('konfirmasi-tables-container');
                if (orderData.tables && orderData.tables.length > 0) {
                    tablesContainer.innerHTML = '';
                    orderData.tables.forEach(table => {
                        const tableHtml = `
                            <div class="table-info-card">
                                <img src="${table.image}" class="table-img">
                                <div class="table-text">
                                    <div class="table-name">${table.name} <span class="table-capacity">${table.capacity} Orang</span></div>
                                    <div class="table-type">${table.type === 'vip' ? 'VIP' : 'Regular'}</div>
                                </div>
                            </div>
                        `;
                        tablesContainer.insertAdjacentHTML('beforeend', tableHtml);
                    });
                }

                // Dates & times
                document.getElementById('konfirmasi-date').innerText = orderData.date;
                document.getElementById('konfirmasi-time').innerText = orderData.time;
                document.getElementById('konfirmasi-duration').innerText = orderData.duration;

                // Pricing
                document.getElementById('konfirmasi-subtotal').innerText = orderData.subtotal;
                document.getElementById('konfirmasi-tax').innerText = orderData.tax;
                document.getElementById('konfirmasi-total').innerText = orderData.total;
                document.getElementById('modal-total-value').innerText = orderData.total;
            }            const mainPayBtn = document.getElementById('main-pay-btn');

            mainPayBtn.addEventListener('click', function() {
                const orderDataRaw = localStorage.getItem('meja_order');
                
                if (!orderDataRaw) {
                    Swal.fire({ icon: 'error', title: 'Data tidak ditemukan', text: 'Silakan pilih meja kembali.', background: '#141418', color: '#fff' });
                    return;
                }

                const orderData = JSON.parse(orderDataRaw);
                const cleanTotal = parseInt(orderData.total.replace(/[^0-9]/g, ''));
                
                // Use reliable isoDate from localStorage
                const formattedDate = orderData.isoDate || new Date().toISOString().split('T')[0];

                const payload = {
                    table_ids: orderData.tables.map(t => t.id),
                    customer_name: '<?php echo e(Auth::user()->name); ?>',
                    phone: '<?php echo e(Auth::user()->phone ?? ""); ?>',
                    booking_date: formattedDate,
                    start_time: orderData.time.split(' - ')[0],
                    end_time: orderData.time.split(' - ')[1],
                    total_price: cleanTotal,
                    _token: '<?php echo e(csrf_token()); ?>'
                };

                mainPayBtn.disabled = true;
                mainPayBtn.innerText = 'Memproses...';

                console.log('Sending payload to server:', payload);

                fetch('<?php echo e(route("booking.store")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(err => { throw err; });
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('Server response:', data);
                    if (data.snap_token) {
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                console.log('Payment success:', result);
                                fetch('<?php echo e(route("booking.success")); ?>', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                                    body: JSON.stringify({ order_id: result.order_id })
                                });
                                saveLocalHistory(result.order_id, orderData, result.payment_type || 'Midtrans');
                                showSuccessUI();
                            },
                            onPending: function(result) {
                                Swal.fire({ icon: 'info', title: 'Menunggu Pembayaran', text: 'Selesaikan pembayaran Anda.', background: '#141418', color: '#fff' });
                            },
                            onError: function(result) {
                                console.error('Snap Error:', result);
                                Swal.fire({ icon: 'error', title: 'Pembayaran Gagal', text: 'Terjadi kesalahan pada sistem Midtrans.', background: '#141418', color: '#fff' });
                            },
                            onClose: function() {
                                console.log('Customer closed popup');
                                mainPayBtn.disabled = false;
                                mainPayBtn.innerText = 'Bayar Sekarang';
                            }
                        });
                    } else {
                        throw new Error(data.message || 'Gagal mendapatkan Snap Token dari server.');
                    }
                })
                .catch(err => {
                    console.error('Process Error:', err);
                    let errMsg = err.message || 'Terjadi kesalahan sistem.';
                    if (err.errors) {
                        errMsg = Object.values(err.errors).flat().join(', ');
                    }
                    Swal.fire({ icon: 'error', title: 'Gagal Memproses', text: errMsg, background: '#141418', color: '#fff' });
                    mainPayBtn.disabled = false;
                    mainPayBtn.innerText = 'Bayar Sekarang';
                });
            });

            function saveLocalHistory(orderId, orderData, method) {
                const historyData = JSON.parse(localStorage.getItem('billiard_history') || '[]');
                const newEntry = {
                    id: orderId,
                    customer_name: '<?php echo e(Auth::user()->name); ?>',
                    tables: orderData.tables.map(t => t.name).join(', '),
                    date: orderData.date,
                    time: orderData.time.split(' - ')[0],
                    duration: orderData.duration,
                    total: orderData.total,
                    status: 'paid',
                    payment_method: method,
                    timestamp: new Date().getTime()
                };
                historyData.unshift(newEntry);
                localStorage.setItem('billiard_history', JSON.stringify(historyData));
            }

            function showSuccessUI() {
                document.getElementById('success-overlay').classList.add('active');
            }
;

            // DOWNLOAD STRUK LOGIC
            const downloadBtn = document.querySelector('.btn-download');
            if (downloadBtn) {
                downloadBtn.addEventListener('click', function() {
                    const modal = document.querySelector('.success-modal');
                    
                    // Style adjustments for capture (optional, e.g. hiding buttons)
                    const actions = document.querySelector('.success-actions');
                    actions.style.display = 'none';

                    html2canvas(modal, {
                        backgroundColor: '#111317',
                        scale: 2, // Higher quality
                        logging: false,
                        useCORS: true
                    }).then(canvas => {
                        // Restore buttons
                        actions.style.display = 'flex';

                        // Trigger Download
                        const link = document.createElement('a');
                        link.download = `Struk_Billiard_${new Date().getTime()}.png`;
                        link.href = canvas.toDataURL('image/png');
                        link.click();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Struk berhasil diunduh ke perangkat Anda.',
                            background: '#141418',
                            color: '#fff',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    });
                });
            }

            // Demo Countdown Logic
            let hours = 0;
            let minutes = 22;
            let seconds = 30;

            const timeBoxes = document.querySelectorAll('.time-box');

            function updateTimer() {
                if (seconds > 0) {
                    seconds--;
                } else {
                    if (minutes > 0) {
                        minutes--;
                        seconds = 59;
                    } else {
                        if (hours > 0) {
                            hours--;
                            minutes = 59;
                            seconds = 59;
                        }
                    }
                }

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

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/dashboard_user/konfirmasi_pembayaran.blade.php ENDPATH**/ ?>