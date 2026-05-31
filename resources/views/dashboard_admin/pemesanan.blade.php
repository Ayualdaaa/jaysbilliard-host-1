<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>History Pemesanan — Jay's Billiard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/css_layout/app_admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css_page/pemesanan.css') }}">
</head>
<body>
    <div class="adm-layout">
        @include('component.c_dashboard.sidebar.sidebar_admin')

        <main class="adm-main">
            {{-- Top Bar --}}
            @include('component.c_dashboard.topbar.topbar', [
                'topbar_title' => 'History Pemesanan',
                'topbar_sub' => 'Data riwayat transaksi dan pemesanan pelanggan'
            ])

            <div class="adm-content adm-history-content">
                
                {{-- ═══════ TOP STATS ═══════ --}}
                <div class="adm-history-stats">
                    <div class="adm-hstat-card">
                        <div class="adm-hstat-icon" style="color: #00ffaa; background: rgba(0,255,170,0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <div class="adm-hstat-info">
                            <span class="adm-hstat-label">TOTAL PEMESANAN</span>
                            <span class="adm-hstat-value" id="statTotalBookings">{{ $totalBookings ?? 0 }}X</span>
                        </div>
                    </div>
 
                    <div class="adm-hstat-card">
                        <div class="adm-hstat-icon" style="color: #00e5ff; background: rgba(0,229,255,0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>
                            </svg>
                        </div>
                        <div class="adm-hstat-info">
                            <span class="adm-hstat-label">TOTAL F&B ORDER</span>
                            <span class="adm-hstat-value" id="statTotalOrders">{{ $totalOrders ?? 0 }} Pesanan</span>
                        </div>
                    </div>

                    <div class="adm-hstat-card">
                        <div class="adm-hstat-icon" style="color: #ffb300; background: rgba(255,179,0,0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div class="adm-hstat-info">
                            <span class="adm-hstat-label">STATUS</span>
                            <span class="adm-hstat-value">Aktif</span>
                        </div>
                    </div>
                </div>

                {{-- ═══════ SEARCH & ACTIONS ═══════ --}}
                <div class="adm-history-actions" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div class="adm-search-wrap">
                        <svg class="adm-search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" class="adm-search-input" placeholder="Cari Meja">
                    </div>
                </div>

                {{-- ═══════ DATA TABLE ═══════ --}}
                <div class="adm-table-container">
                    <div class="adm-table-scroller">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th class="col-id">ID</th>
                                    <th class="col-customer">NAMA PELANGGAN</th>
                                    <th class="col-meja">MEJA</th>
                                    <th class="col-menu">MAKANAN & MINUMAN</th>
                                    <th class="col-datetime">TANGGAL/WAKTU</th>
                                    <th class="col-duration">DURASI</th>
                                    <th class="col-status">STATUS</th>
                                    <th class="col-action">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $index => $booking)
                                    @php
                                        $initial = strtoupper(substr($booking->customer_name, 0, 1));
                                        $colors = ['#ff5252', '#00acc1', '#26c6da', '#ffb300', '#ab47bc'];
                                        $color = $colors[$index % count($colors)];
                                        
                                        // Status Logic Sync
                                        $statusPill = '';
                                        $rawStatus = strtolower($booking->status);
                                        
                                        if (in_array($rawStatus, ['completed', 'selesai'])) {
                                            $statusPill = '<span class="status-pill completed" style="background: rgba(255,82,82,0.1); color: #ff5252; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">Selesai</span>';
                                        } elseif (in_array($rawStatus, ['confirmed', 'paid', 'lunas'])) {
                                            $statusPill = '<span class="status-pill paid" style="background: rgba(0,229,255,0.1); color: #00e5ff; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">Lunas</span>';
                                        } elseif ($rawStatus == 'pending') {
                                            $statusPill = '<span class="status-pill pending" style="background: rgba(255,179,0,0.1); color: #ffb300; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">Pending</span>';
                                        } elseif ($rawStatus == 'cancelled' || $rawStatus == 'batal') {
                                            $statusPill = '<span class="status-pill cancelled" style="background: rgba(255,255,255,0.05); color: #888; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">Batal</span>';
                                        } else {
                                            $statusPill = '<span class="status-pill" style="background: rgba(255,255,255,0.1); color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">'.ucfirst($booking->status).'</span>';
                                        }
                                        
                                        // Duration Logic
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

                                        // F&B Summary Logic
                                        $fnbItems = $booking->orders;
                                        $menuSummary = [];
                                        $allDetails = collect();
                                        foreach($fnbItems as $order) {
                                            foreach($order->details as $detail) {
                                                if($detail->menu) {
                                                    $menuSummary[] = $detail->menu->name . ' (x' . $detail->quantity . ')';
                                                    $allDetails->push([
                                                        'name' => $detail->menu->name,
                                                        'quantity' => $detail->quantity,
                                                        'price' => $detail->price
                                                    ]);
                                                }
                                            }
                                        }
                                        $fnbString = implode(', ', $menuSummary);
                                    @endphp
                                    <tr>
                                        <td class="col-id">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="col-customer">
                                                <div class="cust-avatar" style="background: {{ $color }};">{{ $initial }}</div>
                                                <span class="cust-name">{{ $booking->customer_name }}</span>
                                            </div>
                                        </td>
                                        <td><span class="meja-badge">{{ $booking->table->name ?? 'Meja' }}</span></td>
                                        <td>
                                            @if(count($menuSummary) > 0)
                                                <div class="menu-list-inline" style="font-size: 0.75rem; color: var(--primary-cyan); font-weight: 700; max-width: 150px; line-height: 1.4; word-wrap: break-word;">
                                                    {{ $fnbString }}
                                                </div>
                                            @else
                                                <span class="menu-empty">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="date-primary">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
                                            <span class="time-secondary">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</span>
                                        </td>
                                        <td><span class="col-duration">{{ $duration }}</span></td>
                                        <td>
                                            <div class="status-edit-wrapper" style="cursor: pointer;" onclick="editStatus('{{ $booking->id }}', '{{ $booking->status }}')" title="Klik untuk ubah status">
                                                {!! $statusPill !!}
                                                <svg style="margin-left: 5px; color: #666;" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                            </div>
                                        </td>
                                        <td class="col-action">
                                            <div class="adm-action-buttons">
                                                <button type="button" class="btn-action view" style="background: transparent; color: #ffb300;" 
                                                    onclick='showOrderDetails(
                                                        "{{ htmlspecialchars($booking->customer_name, ENT_QUOTES) }}", 
                                                        "{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}", 
                                                        "{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}", 
                                                        "{{ $booking->table->name ?? 'Meja' }}", 
                                                        "{{ $duration }}", 
                                                        "{{ $booking->payment_method ?? 'Midtrans' }}", 
                                                        {!! json_encode($allDetails) !!}, 
                                                        "Rp {{ number_format($booking->total_price, 0, ',', '.') }}"
                                                    )' title="View Details">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                </button>
                                                @if(strtolower($booking->status) !== 'completed')
                                                <form action="{{ route('admin.booking.complete', $booking->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-action edit" style="background: transparent; color: #00e5ff;" onclick="return confirmComplete(this.form, '{{ htmlspecialchars($booking->customer_name, ENT_QUOTES) }}')" title="Selesaikan Pesanan">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" style="text-align: center; padding: 60px; color: rgba(255,255,255,0.1);">Belum ada riwayat pemesanan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Table Footer --}}
                    <div class="adm-table-footer">
                        <div class="adm-pagination-info">
                            {{-- Populated via JS --}}
                        </div>
                        <div class="adm-pagination-links">
                            {{-- Populated via JS --}}
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════ ORDER DETAIL MODAL ═══════════════════════════════ --}}
                <div class="adm-detail-modal-overlay" id="orderDetailModal">
                    <div class="adm-detail-modal">
                        <div class="modal-details-header">
                            <button type="button" class="btn-close-modal" onclick="closeOrderDetailModal()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                            <span class="detail-cust-name" id="detCustName">Ayu Alda Fu</span>
                            <div class="detail-datetime-row">
                                <span class="detail-dt-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    <span id="detDate">24 Oct 2023</span>
                                </span>
                                <span class="detail-dt-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    <span id="detTime">19:30</span>
                                </span>
                            </div>
                        </div>

                        <div class="modal-details-body">
                            <div class="modal-separator"></div>
                            
                            <span class="section-label">MEJA & PEMBAYARAN</span>
                            <div class="panel-meja-info">
                                <div class="meja-info-row">
                                    <span class="meja-info-label">MEJA</span>
                                    <span class="meja-info-val" id="detMejaNum">04 [VIP]</span>
                                </div>
                                <div class="meja-info-row">
                                    <span class="meja-info-label">LAMA WAKTU</span>
                                    <span class="meja-info-val" id="detDuration">01:30:00</span>
                                </div>
                                <div class="meja-info-row" style="margin-top: 8px; border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 8px;">
                                    <span class="meja-info-label">METODE</span>
                                    <span class="meja-info-val" id="detPaymentMethod" style="color: #00e5ff; font-weight: 700;">QRIS</span>
                                </div>
                            </div>

                            <span class="section-label">MAKANAN & MINUMAN</span>
                            <div class="fnb-list">
                                {{-- Populated via JS --}}
                            </div>

                            <div class="detail-summary">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span id="detSubtotal">Rp 0</span>
                                </div>
                                <div class="summary-row grand-total">
                                    <span class="gt-label">GRAND TOTAL</span>
                                    <span class="gt-val">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmComplete(form, customerName) {
            Swal.fire({
                title: 'Selesaikan Pesanan',
                html: `Apakah Anda yakin ingin menyelesaikan pesanan <b>${customerName}</b>? <br><span style="font-size: 0.85rem; color: #8a8a98; margin-top: 10px; display: block;">Status meja akan kembali normal dan riwayat akan ditandai Selesai.</span>`,
                icon: 'info',
                iconColor: '#00e5ff',
                showCancelButton: true,
                confirmButtonText: 'SELESAI',
                cancelButtonText: 'BATAL',
                background: '#111418',
                color: '#fff',
                confirmButtonColor: '#00e5ff',
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

        function confirmDelete(form, customerName) {
            Swal.fire({
                title: 'Hapus Riwayat',
                html: `Apakah Anda yakin ingin menghapus data riwayat pemesanan <b>${customerName}</b>? <br><span style="font-size: 0.85rem; color: #8a8a98; margin-top: 10px; display: block;">jika anda menghapusnya nanti data riwayat ini tidak ada lagi secara permanen</span>`,
                icon: 'warning',
                iconColor: '#ff5252',
                showCancelButton: true,
                confirmButtonText: 'HAPUS',
                cancelButtonText: 'BATAL',
                background: '#111418',
                color: '#fff',
                confirmButtonColor: '#ff5252',
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

        function editStatus(bookingId, currentStatus) {
            Swal.fire({
                title: 'Ubah Status Pemesanan',
                input: 'select',
                inputOptions: {
                    'pending': 'Pending',
                    'confirmed': 'Lunas / Confirmed',
                    'completed': 'Selesai / Completed',
                    'cancelled': 'Dibatalkan / Cancelled'
                },
                inputValue: currentStatus,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                background: '#111418',
                color: '#fff',
                confirmButtonColor: '#00e5ff',
                cancelButtonColor: 'transparent',
                didOpen: () => {
                    const cancelBtn = document.querySelector('.swal2-cancel');
                    if(cancelBtn) cancelBtn.style.color = '#8a8a98';
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/booking/${bookingId}/status`;
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    
                    const statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'status';
                    statusInput.value = result.value;
                    
                    form.appendChild(csrf);
                    form.appendChild(statusInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function showOrderDetails(name, date, time, meja, duration, paymentMethod = 'QRIS', fnbItems = [], total = 'Rp 0') {
            document.getElementById('detCustName').innerText = name;
            document.getElementById('detDate').innerText = date;
            document.getElementById('detTime').innerText = time;
            document.getElementById('detMejaNum').innerText = meja;
            document.getElementById('detDuration').innerText = duration;
            document.getElementById('detPaymentMethod').innerText = paymentMethod;

            const fnbContainer = document.querySelector('.fnb-list');
            if (fnbContainer) {
                fnbContainer.innerHTML = '';
                if (fnbItems && fnbItems.length > 0) {
                    fnbItems.forEach(item => {
                        const price = (item.price * item.quantity).toLocaleString('id-ID');
                        fnbContainer.insertAdjacentHTML('beforeend', `<div class="fnb-item"><div class="fnb-info-main">${item.name} <span class="fnb-qty">${item.quantity}x</span></div><div class="fnb-price">Rp ${price}</div></div>`);
                    });
                } else {
                    fnbContainer.innerHTML = '<div style="color: var(--text-muted); font-size: 0.8rem;">Tidak ada pesanan F&B</div>';
                }
            }
            document.querySelector('.grand-total .gt-val').innerText = total;
            document.getElementById('detSubtotal').innerText = total;
            document.getElementById('orderDetailModal').classList.add('open');
        }

        function closeOrderDetailModal() { document.getElementById('orderDetailModal').classList.remove('open'); }

        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('adm-detail-modal-overlay')) closeOrderDetailModal();
        });
    </script>
</body>
</html>
