@extends('layouts.dashboard')

@section('title', "Riwayat Pesanan — Jay's Billiard")

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/css_page/dashboard_user.css') }}">
    <style>
        .history-container {
            padding: 24px;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .stat-label {
            color: #8c8f94;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .stat-value {
            color: #fff;
            font-size: 2.2rem;
            font-weight: 900;
            line-height: 1;
        }

        /* Main Content Card */
        .main-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(12px);
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .search-wrapper {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            padding: 10px 16px;
            width: 320px;
            transition: border-color 0.3s;
        }

        .search-wrapper:focus-within {
            border-color: rgba(0, 229, 255, 0.5);
        }
        
        .search-wrapper svg {
            color: #8c8f94;
            margin-right: 12px;
            width: 18px;
            height: 18px;
        }
        
        .search-wrapper input {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 0.9rem;
            width: 100%;
            outline: none;
        }
        
        .search-wrapper input::placeholder {
            color: #8c8f94;
        }
        
        .filter-tabs {
            display: flex;
            gap: 4px;
            background: rgba(0, 0, 0, 0.2);
            padding: 4px;
            border-radius: 10px;
        }
        
        .filter-btn {
            background: transparent;
            border: none;
            color: #8c8f94;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .filter-btn.active {
            background: #00e5ff;
            color: #000;
        }

        /* History List */
        .history-list {
            display: flex;
            flex-direction: column;
        }
        
        .history-item {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            gap: 14px;
            transition: background 0.3s;
        }

        .history-item:hover {
            background: rgba(255, 255, 255, 0.01);
        }
        
        .history-item:last-child {
            border-bottom: none;
        }
        
        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .type-badge {
            background: rgba(0, 229, 255, 0.08);
            color: #00e5ff;
            border: 1px solid rgba(0, 229, 255, 0.2);
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .type-badge-fnb {
            background: rgba(255, 171, 0, 0.08);
            color: #ffab00;
            border-color: rgba(255, 171, 0, 0.2);
        }
        
        .status-badge {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 14px;
            border: 1px solid rgba(46, 213, 115, 0.2);
            background: rgba(46, 213, 115, 0.08);
            color: #2ed573;
            letter-spacing: 0.5px;
        }

        .status-pending {
            border-color: rgba(255, 171, 0, 0.2);
            background: rgba(255, 171, 0, 0.08);
            color: #ffab00;
        }

        .item-id {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #8c8f94;
            font-size: 0.75rem;
            font-family: monospace;
            font-weight: 700;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 6px 12px;
            border-radius: 6px;
            width: fit-content;
            margin-bottom: 4px;
        }
        
        .item-id svg {
            width: 14px;
            height: 14px;
            color: #8c8f94;
        }
        
        .item-title {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: 0.3px;
        }
        
        .item-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 2px;
        }
        
        .detail-row {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #a0a5ad;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .detail-row svg {
            width: 16px;
            height: 16px;
            color: #5c626b;
        }
        
        .item-price {
            color: #00e5ff;
            font-size: 1.2rem;
            font-weight: 800;
            text-align: right;
            margin-top: -30px;
            letter-spacing: 0.5px;
        }

        .hidden {
            display: none !important;
        }
        
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: rgba(255, 255, 255, 0.4);
        }
    </style>
@endpush

@section('content')
@php
    $totalBookings = $bookings->count();
    $totalFnb = $fnbOrders->count();
    $totalHistory = $totalBookings + $totalFnb;
@endphp

<div class="history-container">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">TOTAL RIWAYAT</span>
            <span class="stat-value">{{ $totalHistory }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">BOOKING MEJA</span>
            <span class="stat-value">{{ $totalBookings }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">PESANAN F&B</span>
            <span class="stat-value">{{ $totalFnb }}</span>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <!-- Toolbar -->
        <div class="toolbar">
            <div class="search-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari riwayat">
            </div>
            
            <div class="filter-tabs">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="meja">Meja</button>
                <button class="filter-btn" data-filter="fnb">F&B</button>
            </div>
        </div>

        <!-- History List -->
        <div class="history-list">
            @php
                $allItems = collect();
                
                foreach($bookings as $booking) {
                    $allItems->push((object)[
                        'type' => 'meja',
                        'data' => $booking,
                        'date_sort' => \Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->start_time)
                    ]);
                }
                
                foreach($fnbOrders as $order) {
                    $allItems->push((object)[
                        'type' => 'fnb',
                        'data' => $order,
                        'date_sort' => \Carbon\Carbon::parse($order->created_at)
                    ]);
                }
                
                $allItems = $allItems->sortByDesc('date_sort');
            @endphp

            @forelse($allItems as $item)
                @if($item->type === 'meja')
                    @php $booking = $item->data; @endphp
                    <div class="history-item" data-type="meja" data-search="{{ strtolower('booking meja ' . ($booking->table->name ?? '')) }} bkg-{{ $booking->id }}">
                        <div class="item-header">
                            <span class="type-badge">BOOKING MEJA</span>
                            <span class="status-badge {{ $booking->status === 'confirmed' || $booking->status === 'completed' || $booking->status === 'paid' ? '' : 'status-pending' }}">
                                {{ in_array($booking->status, ['confirmed', 'paid']) ? 'BERHASIL' : ($booking->status === 'completed' ? 'SELESAI' : strtoupper($booking->status)) }}
                            </span>
                        </div>
                        
                        <div class="item-id">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            ID: BKG-{{ $booking->id }}
                        </div>
                        
                        <h3 class="item-title">Booking {{ ucwords($booking->table->name ?? 'Meja') }}</h3>
                        
                        <div class="item-details">
                            <div class="detail-row">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}, {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }} WIB
                            </div>
                            <div class="detail-row">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                Durasi {{ \Carbon\Carbon::parse($booking->start_time)->diffInHours(\Carbon\Carbon::parse($booking->end_time)) }} Jam
                            </div>
                            <div class="detail-row">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                {{ strtoupper(str_replace('_', ' ', $booking->payment_method ?? '-')) }}
                            </div>
                        </div>
                        
                        <div class="item-price">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </div>
                    </div>
                @else
                    @php $order = $item->data; @endphp
                    <div class="history-item" data-type="fnb" data-search="{{ strtolower('pesanan f&b ' . $order->order_id) }} {{ strtolower($order->order_id) }}">
                        <div class="item-header">
                            <span class="type-badge type-badge-fnb">PESANAN F&B</span>
                            <span class="status-badge {{ $order->status === 'paid' ? '' : 'status-pending' }}">
                                {{ $order->status === 'paid' ? 'BERHASIL' : 'PENDING' }}
                            </span>
                        </div>
                        
                        <div class="item-id">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            ID: {{ $order->order_id }}
                        </div>
                        
                        <h3 class="item-title">Pesanan Makanan & Minuman</h3>
                        
                        <div class="item-details">
                            <div class="detail-row">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                {{ \Carbon\Carbon::parse($order->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                            </div>
                            <div class="detail-row">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                {{ $order->details->sum('quantity') }} Item
                            </div>
                            <div class="detail-row">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                {{ strtoupper(str_replace('_', ' ', $order->payment_method ?? '-')) }} (Antar ke: {{ strtoupper($order->booking->table->name ?? 'Meja') }})
                            </div>
                        </div>
                        
                        <div class="item-price">
                            Rp {{ number_format($order->total_price_fnb, 0, ',', '.') }}
                        </div>
                    </div>
                @endif
            @empty
                <div class="empty-state">
                    Belum ada riwayat pesanan.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const historyItems = document.querySelectorAll('.history-item');

        function filterHistory() {
            const searchTerm = searchInput.value.toLowerCase();
            const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;

            historyItems.forEach(item => {
                const itemType = item.dataset.type;
                const itemSearchData = item.dataset.search;

                const matchesSearch = itemSearchData.includes(searchTerm);
                const matchesFilter = activeFilter === 'all' || itemType === activeFilter;

                if (matchesSearch && matchesFilter) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        }

        searchInput.addEventListener('input', filterHistory);

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                filterHistory();
            });
        });
    });
</script>
@endpush
