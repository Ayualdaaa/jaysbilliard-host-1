@extends('layouts.dashboard')

@section('title', "Konfirmasi Pembayaran — Jay's Billiard")

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/css_page/konfirmasi_pembayaran.css') }}">
@endpush

@section('content')
    <div class="konfirmasi-wrapper">
        {{-- LEFT COLUMN: ORDER SUMMARY --}}
        <div class="summary-container">
            <h3 class="summary-title">Ringkasan Pemesanan</h3>

            <div id="konfirmasi-tables-container" style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px;">
                {{-- Populated by JS --}}
                <div class="table-info-card">
                    <img src="{{ asset('images/hero-bg.png') }}" alt="Meja" class="table-img" id="konfirmasi-img">
                    <div class="table-text">
                        <div class="table-name" id="konfirmasi-name">Pilih Meja <span class="table-capacity" id="konfirmasi-ppl">0 Orang</span></div>
                        <div class="table-type" id="konfirmasi-type">Standar</div>
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

        {{-- RIGHT COLUMN: FINAL CONFIRMATION --}}
        <div class="payment-main-area">
            {{-- Countdown Timer --}}
            <div class="timer-card">
                <div class="timer-icon" style="background: rgba(0, 242, 255, 0.08); border-radius: 12px; width: 44px; height: 44px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div class="timer-info">
                    <div class="timer-label">Batas Waktu Pembayaran</div>
                    <div class="timer-sub">Selesaikan pembayaran melalui Midtrans Snap</div>
                </div>
                <div class="countdown-display">
                    <div class="time-unit">
                        <div class="time-box">0</div>
                        <div class="time-label">HRS</div>
                    </div>
                    <div class="time-dots">:</div>
                    <div class="time-unit">
                        <div class="time-box">21</div>
                        <div class="time-label">MIN</div>
                    </div>
                    <div class="time-dots">:</div>
                    <div class="time-unit">
                        <div class="time-box">32</div>
                        <div class="time-label">SEC</div>
                    </div>
                </div>
            </div>

            {{-- Confirmation Card --}}
            <div class="methods-card">
                <!-- Header Card Content -->
                <div style="margin-bottom: 30px;">
                    <div style="width: 60px; height: 60px; background: rgba(0, 242, 255, 0.08); border-radius: 18px; display: flex; align-items: center; justify-content: center; color: var(--primary-cyan); margin-bottom: 20px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    </div>
                    <h3 style="font-size: 1.4rem; font-weight: 900; color: #fff; margin-bottom: 12px;">Pembayaran Midtrans</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                        Semua metode pembayaran diproses langsung oleh Midtrans. Pilih QRIS, DANA, atau GoPay untuk membuka alur pembayaran yang sesuai.
                    </p>
                </div>

                <div class="category-header" style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px; color: #fff; font-weight: 800;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-cyan)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    <span style="font-size: 1rem;">Pilih Metode Pembayaran</span>
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

                <div class="method-info-text" style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5; margin-top: 24px; margin-bottom: 30px; text-align: left;">
                    DANA redirect memakai Snap-BI Direct Debit jika credential tersedia.
                </div>

                <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--card-border); border-radius: 16px; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <span style="font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">GATEWAY</span>
                        <span style="font-size: 1rem; font-weight: 800; color: #fff;">Midtrans Snap</span>
                    </div>
                </div>

                <div class="konfirmasi-footer" style="width: 100%; display: flex; justify-content: flex-end; align-items: center; gap: 24px;">
                    <a href="{{ route('user.meja') }}" class="cancel-link" id="cancel-btn" style="font-size: 1rem; font-weight: 700; color: var(--text-muted); text-decoration: none; transition: color 0.2s;">Cancel</a>
                    <button class="pay-btn" id="main-pay-btn" style="padding: 16px 32px; font-size: 1.1rem; font-weight: 900; border-radius: 14px; text-transform: none;">Bayar QRIS via Midtrans</button>
                </div>
            </div>
        </div>
    </div>

    {{-- PAYMENT SUCCESS MODAL --}}
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
                <a href="{{ route('user.meja') }}" class="btn-kembali">Kembali</a>
                <button class="btn-download">Download Struk</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const methodOptions = document.querySelectorAll('.method-option');
            const mainPayBtn = document.getElementById('main-pay-btn');

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
                                    <div class="table-type">${table.type === 'vip' ? 'VIP' : 'Standar'}</div>
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
            }

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
                    customer_name: '{{ Auth::user()->name }}',
                    phone: '{{ Auth::user()->phone ?? "" }}',
                    booking_date: formattedDate,
                    start_time: orderData.time.split(' - ')[0],
                    end_time: orderData.time.split(' - ')[1],
                    total_price: cleanTotal,
                    _token: '{{ csrf_token() }}'
                };

                mainPayBtn.disabled = true;
                mainPayBtn.innerText = 'Memproses...';

                console.log('Sending payload to server:', payload);

                fetch('{{ route("booking.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                                fetch('{{ route("booking.success") }}', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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
                    customer_name: '{{ Auth::user()->name }}',
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
@endpush
