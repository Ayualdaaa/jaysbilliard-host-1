@extends('layouts.dashboard')

@section('title', "Riwayat Pesanan — Jay's Billiard")

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/css_page/dashboard_user.css') }}">
    <style>
        .history-container {
            padding: 24px;
        }
        
        /* Premium Tabs Styling */
        .history-tabs {
            display: flex;
            gap: 16px;
            margin-bottom: 28px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 16px;
        }
        
        .tab-btn {
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.6);
            padding: 12px 24px;
            border-radius: 14px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.04);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }
        
        .tab-btn.active {
            background: rgba(0, 229, 255, 0.1);
            color: #00e5ff;
            border-color: #00e5ff;
            box-shadow: 0 0 20px rgba(0, 229, 255, 0.15);
        }
        
        .tab-panel {
            display: none;
            animation: panelFadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .tab-panel.active {
            display: block;
        }
        
        @keyframes panelFadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .history-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 20px;
            overflow: hidden;
            backdrop-filter: blur(12px);
        }
        
        .history-table {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
        }
        
        .history-table th {
            text-align: left;
            padding: 18px;
            background: rgba(0, 229, 255, 0.08);
            color: #00e5ff;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            border-bottom: 1px solid rgba(0, 229, 255, 0.15);
        }
        
        .history-table td {
            padding: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 14.5px;
            vertical-align: middle;
        }
        
        .history-table tr:hover td {
            background: rgba(255, 255, 255, 0.01);
        }
        
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }
        
        .status-confirmed {
            background: rgba(0, 229, 255, 0.12);
            color: #00e5ff;
            border: 1px solid rgba(0, 229, 255, 0.25);
        }
        
        .status-completed {
            background: rgba(46, 213, 115, 0.12);
            color: #2ed573;
            border: 1px solid rgba(46, 213, 115, 0.25);
        }
        
        .status-pending {
            background: rgba(255, 171, 0, 0.12);
            color: #ffab00;
            border: 1px solid rgba(255, 171, 0, 0.25);
        }
        
        .empty-state {
            padding: 70px 20px;
            text-align: center;
            color: rgba(255, 255, 255, 0.35);
        }
        
        .empty-state svg {
            margin-bottom: 20px;
            opacity: 0.15;
            color: #00e5ff;
        }
    </style>
@endpush

@section('content')
    <div class="history-container">
        
        {{-- Navigation Tabs --}}
        <div class="history-tabs">
            <button class="tab-btn active" data-tab="meja">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                Pemesanan Meja
            </button>
            <button class="tab-btn" data-tab="fnb">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                Makanan & Minuman
            </button>
        </div>

        {{-- Panel 1: Table Booking History --}}
        <div class="tab-panel active" id="panel-meja">
            <div class="history-card">
                @if($bookings->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">No</th>
                                    <th>Meja</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $index => $booking)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td style="font-weight: 700; color: #00e5ff;">{{ strtoupper($booking->table->name ?? 'Meja') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                                        <td style="font-weight: 700;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $booking->status }}">
                                                {{ $booking->status === 'confirmed' ? 'DIPESAN' : ($booking->status === 'completed' ? 'SELESAI' : strtoupper($booking->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <p style="font-weight: 700; font-size: 1.05rem;">Belum ada riwayat pemesanan meja.</p>
                        <a href="{{ route('user.meja') }}" class="btn-neon" style="margin-top: 20px; display: inline-block; text-decoration: none;">PESAN MEJA SEKARANG</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Panel 2: F&B Order History --}}
        <div class="tab-panel" id="panel-fnb">
            <div class="history-card">
                @if($fnbOrders->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">No</th>
                                    <th>Order ID</th>
                                    <th>Antar ke Meja</th>
                                    <th>Menu Dipesan</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fnbOrders as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td style="font-family: monospace; font-size: 0.82rem; color: rgba(255, 255, 255, 0.6);">{{ $order->order_id }}</td>
                                        <td style="font-weight: 700; color: #00e5ff;">{{ strtoupper($order->booking->table->name ?? 'Meja') }}</td>
                                        <td>
                                            @foreach($order->details as $detail)
                                                <div style="font-size: 0.85rem; margin-bottom: 3px; font-weight: 600;">
                                                    • {{ $detail->menu->name ?? 'Menu' }} <span style="color: #00e5ff; font-weight: 800;">(x{{ $detail->quantity }})</span>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</td>
                                        <td style="font-weight: 800; color: #2ed573;">Rp {{ number_format($order->total_price_fnb, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $order->status === 'paid' ? 'completed' : 'pending' }}">
                                                {{ $order->status === 'paid' ? 'LUNAS' : 'PENDING' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        <p style="font-weight: 700; font-size: 1.05rem;">Belum ada riwayat pesanan makanan & minuman.</p>
                        <a href="{{ route('user.fnb') }}" class="btn-neon" style="margin-top: 20px; display: inline-block; text-decoration: none;">PESAN MAKANAN SEKARANG</a>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabPanels = document.querySelectorAll('.tab-panel');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabPanels.forEach(p => p.classList.remove('active'));

                    btn.classList.add('active');
                    const tabId = btn.dataset.tab;
                    document.getElementById(`panel-${tabId}`).classList.add('active');
                });
            });
        });
    </script>
@endpush
