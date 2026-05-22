<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manajemen Transaksi — Jay's Billiard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/css_layout/app_admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css_page/pemesanan.css') }}">
    <style>
        .income-positive { color: #ffffff !important; font-weight: 850; }
        .income-negative { color: #ffffff !important; font-weight: 850; opacity: 0.6; }
        .method-badge {
            padding: 4px 10px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #fff;
        }
        .status-pill.failed {
            background: rgba(255, 82, 82, 0.05);
            border-color: rgba(255, 82, 82, 0.12);
            color: #ff5252;
        }
    </style>
</head>
<body>
    <div class="adm-layout">
        @include('component.c_dashboard.sidebar.sidebar_admin')

        <main class="adm-main">
            {{-- Top Bar --}}
            @include('component.c_dashboard.topbar.topbar', [
                'topbar_title' => 'Manajemen Transaksi',
                'topbar_sub' => 'Pantau semua arus kas dan transaksi pembayaran'
            ])

            <div class="adm-content adm-history-content">
                
                {{-- ═══════ TOP STATS ═══════ --}}
                <div class="adm-history-stats">
                    <div class="adm-hstat-card">
                        <div class="adm-hstat-icon" style="color: #00ffaa; background: rgba(0,255,170,0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                        </div>
                        <div class="adm-hstat-info">
                            <span class="adm-hstat-label">TOTAL PENDAPATAN</span>
                            <span class="adm-hstat-value" id="statTotalIncome">Rp {{ number_format(collect($transactions)->whereIn('status', ['paid', 'completed', 'confirmed'])->sum('total_price'), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="adm-hstat-card">
                        <div class="adm-hstat-icon" style="color: #00e5ff; background: rgba(0,229,255,0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                            </svg>
                        </div>
                        <div class="adm-hstat-info">
                            <span class="adm-hstat-label">TRANSAKSI BERHASIL</span>
                            <span class="adm-hstat-value" id="statTodayCount">{{ collect($transactions)->whereIn('status', ['paid', 'completed', 'confirmed'])->count() }}</span>
                        </div>
                    </div>

                    <div class="adm-hstat-card">
                        <div class="adm-hstat-icon" style="color: #ff5252; background: rgba(255,82,82,0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                            </svg>
                        </div>
                        <div class="adm-hstat-info">
                            <span class="adm-hstat-label">TRANSAKSI GAGAL</span>
                            <span class="adm-hstat-value" id="statFailedCount">{{ collect($transactions)->whereNotIn('status', ['paid', 'completed', 'confirmed', 'pending'])->count() }}</span>
                        </div>
                    </div>
                </div>

                {{-- ═══════ SEARCH & ACTIONS ═══════ --}}
                <div class="adm-history-actions">
                    <div class="adm-search-wrap">
                        <svg class="adm-search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" class="adm-search-input" placeholder="Cari ID Transaksi atau Pelanggan">
                    </div>
                    <div class="adm-filter-group">
                        <button class="btn-filter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                            Filter
                        </button>
                        <button class="btn-export">
                            Laporan Keuangan
                        </button>
                    </div>
                </div>

                {{-- ═══════ DATA TABLE ═══════ --}}
                <div class="adm-table-container">
                    <div class="adm-table-scroller">
                        <table class="adm-table" id="transactionTable">
                            <thead>
                                <tr>
                                    <th class="col-id">ID</th>
                                    <th class="col-customer">PELANGGAN</th>
                                    <th>KATEGORI</th>
                                    <th>PAYMENT TYPE</th>
                                    <th>TANGGAL</th>
                                    <th>JUMLAH</th>
                                    <th>STATUS</th>
                                    <th class="col-action">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="transactionBody">
                                @forelse($transactions as $index => $item)
                                    @php
                                        $initial = strtoupper(substr($item->customer_name, 0, 1));
                                        $status = strtolower($item->status);
                                        $isSuccess = in_array($status, ['paid', 'completed', 'confirmed']);
                                        $statusHtml = $isSuccess ? '<span class="status-pill paid">Berhasil</span>' : '<span class="status-pill failed">Gagal</span>';
                                        $amountClass = $isSuccess ? 'income-positive' : 'income-negative';
                                        
                                        $fnbItems = $item->orders;
                                        $hasFnb = $fnbItems && $fnbItems->count() > 0;
                                        
                                        try {
                                            $start = \Carbon\Carbon::parse($item->booking_date . ' ' . $item->start_time);
                                            $end = \Carbon\Carbon::parse($item->booking_date . ' ' . $item->end_time);
                                            if ($end->lt($start)) {
                                                $end->addDay();
                                            }
                                            $duration = $start->diffInHours($end) . ' Jam';
                                        } catch (\Exception $e) {
                                            $duration = '2 Jam';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="col-id">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="col-customer">
                                                <div class="cust-avatar" style="background: #00bcd4;">{{ $initial }}</div>
                                                <span class="cust-name">{{ $item->customer_name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="method-badge" style="background: rgba(0, 229, 255, 0.05); color: #00e5ff; border-color: rgba(0, 229, 255, 0.2);">
                                                {{ $hasFnb ? 'Booking + F&B' : 'Booking Meja' }}
                                            </span>
                                        </td>
                                        <td><span class="method-badge">{{ $item->payment_method ?? 'QRIS' }}</span></td>
                                        <td>
                                            <span class="date-primary">{{ \Carbon\Carbon::parse($item->booking_date)->format('d M Y') }}</span>
                                            <span class="time-secondary">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}</span>
                                        </td>
                                        <td><span class="{{ $amountClass }}">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span></td>
                                        <td>{!! $statusHtml !!}</td>
                                        <td class="col-action">
                                            <div class="adm-action-buttons">
                                                <button type="button" class="btn-action view" onclick='showOrderDetails("{{ htmlspecialchars($item->customer_name, ENT_QUOTES) }}", "{{ \Carbon\Carbon::parse($item->booking_date)->format('d M Y') }}", "{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}", "{{ $item->table->name ?? 'N/A' }}", "{{ $item->payment_method ?? 'QRIS' }}", "{{ $duration }}", {{ json_encode($fnbItems->map(function($o) { return ["name" => $o->menu_name, "quantity" => $o->quantity, "price" => $o->price ?? 0]; })) }}, "Rp {{ number_format($item->total_price, 0, ',', '.') }}")' title="View Transaction">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" style="text-align: center; padding: 60px; color: rgba(255,255,255,0.15);">Belum ada data transaksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Table Footer --}}
                    <div class="adm-table-footer">
                        <div class="adm-pagination-info"></div>
                        <div class="adm-pagination-links"></div>
                    </div>
                </div>

            </div>
        </main>
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
                
                <span class="section-label">DETAIL TRANSAKSI</span>
                <div class="panel-meja-info">
                    <div class="meja-info-row">
                        <span class="meja-info-label">MEJA</span>
                        <span class="meja-info-val" id="detMejaNum">04 [VIP]</span>
                    </div>
                    <div class="meja-info-row">
                        <span class="meja-info-label">METODE BAYAR</span>
                        <span class="meja-info-val" id="detPaymentMethod">QRIS</span>
                    </div>
                    <div class="meja-info-row">
                        <span class="meja-info-label">DURASI</span>
                        <span class="meja-info-val" id="detDuration">01:30:00</span>
                    </div>
                </div>

                <span class="section-label">MAKANAN & MINUMAN</span>
                <div class="fnb-list"></div>

                <div class="detail-summary">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="detSubtotal">Rp 0</span>
                    </div>
                    <div class="summary-row grand-total">
                        <span class="gt-label">TOTAL AKHIR</span>
                        <span class="gt-val">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.showOrderDetails = function(name, date, time, meja, method, duration, fnbItems = [], total = 'Rp 0') {
            document.getElementById('detCustName').innerText = name;
            document.getElementById('detDate').innerText = date;
            document.getElementById('detTime').innerText = time;
            document.getElementById('detMejaNum').innerText = meja;
            document.getElementById('detPaymentMethod').innerText = method;
            document.getElementById('detDuration').innerText = duration;
            const fnbContainer = document.querySelector('.fnb-list');
            if (fnbContainer) {
                fnbContainer.innerHTML = '';
                if (fnbItems.length > 0) {
                    fnbItems.forEach(item => { fnbContainer.insertAdjacentHTML('beforeend', `<div class="fnb-item"><div class="fnb-info-main">${item.name} <span class="fnb-qty">${item.quantity}x</span></div><div class="fnb-price">Rp ${(item.price * item.quantity || 0).toLocaleString('id-ID')}</div></div>`); });
                } else fnbContainer.innerHTML = '<div style="color: var(--text-muted); font-size: 0.8rem;">Tidak ada pesanan F&B</div>';
            }
            document.getElementById('detSubtotal').innerText = total;
            document.querySelector('.grand-total .gt-val').innerText = total;
            document.getElementById('orderDetailModal').classList.add('open');
        };

        window.closeOrderDetailModal = function() { document.getElementById('orderDetailModal').classList.remove('open'); };
        window.addEventListener('click', function(e) { if (e.target.classList.contains('adm-detail-modal-overlay')) closeOrderDetailModal(); });
    </script>
</body>
</html>
