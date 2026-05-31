<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manajemen Stok F&B — Jay's Billiard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/css_layout/app_admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css_page/pemesanan.css') }}">
    <style>
        .stock-form-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
        }
        .stock-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            align-items: flex-end;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px 14px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
        }
        select.form-control {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 40px;
        }
        .form-control option {
            background-color: #141418;
            color: #fff;
            padding: 10px;
        }
        .form-control:focus {
            border-color: #00e5ff;
            background: rgba(0, 229, 255, 0.05);
            box-shadow: 0 0 10px rgba(0, 229, 255, 0.2);
        }
        .btn-submit-stock {
            background: #00e5ff;
            color: #000;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }
        .btn-submit-stock:hover {
            background: #00b8cc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 229, 255, 0.3);
        }
        .stock-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 700;
        }
        .stock-in { background: rgba(46, 213, 115, 0.15); color: #2ed573; }
        .stock-out { background: rgba(255, 82, 82, 0.15); color: #ff5252; }
        .btn-export-pdf {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 13px;
        }
        .btn-export-pdf:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ff5252;
            color: #ff5252;
        }
    </style>
</head>
<body>
    <div class="adm-layout">
        @include('component.c_dashboard.sidebar.sidebar_admin')

        <main class="adm-main">
            @include('component.c_dashboard.topbar.topbar', [
                'topbar_title' => 'Stok Makanan & Minuman',
                'topbar_sub' => 'Kelola persediaan barang masuk dan keluar per item'
            ])

            <div class="adm-content adm-history-content">
                
                @if(session('success'))
                    <div style="background: rgba(46, 213, 115, 0.1); border: 1px solid #2ed573; color: #2ed573; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div style="background: rgba(255, 82, 82, 0.1); border: 1px solid #ff5252; color: #ff5252; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- ═══════ FORM TRANSAKSI STOK ═══════ --}}
                <div class="stock-form-card">
                    <h3 style="margin-top: 0; margin-bottom: 16px; font-size: 16px; color: #00e5ff;">Input Transaksi Stok</h3>
                    <form action="{{ route('admin.stock.store') }}" method="POST">
                        @csrf
                        <div class="stock-form-grid">
                            <div class="form-group">
                                <label>Item F&B</label>
                                <select name="menu_id" class="form-control" required>
                                    <option value="">Pilih Item...</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name }} (Stok: {{ $menu->stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis</label>
                                <select name="type" class="form-control" required>
                                    <option value="in">MASUK</option>
                                    <option value="out">KELUAR</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" name="quantity" class="form-control" min="1" placeholder="0" required>
                            </div>
                            <div class="form-group">
                                <label>Catatan</label>
                                <input type="text" name="note" class="form-control" placeholder="Opsional...">
                            </div>
                            <button type="submit" class="btn-submit-stock">SIMPAN</button>
                        </div>
                    </form>
                </div>

                {{-- ═══════ SEARCH & ACTIONS ═══════ --}}
                <div class="adm-history-actions" style="margin-top: 32px;">
                    <h3 style="margin: 0; font-size: 16px; color: #fff;">Riwayat Transaksi Stok</h3>
                    <div style="display: flex; gap: 12px; align-items: center;">
                    <form action="{{ route('admin.stock.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center;">
                        <span style="color: rgba(255,255,255,0.7); font-size: 14px; font-weight: 500;">Pendapatan</span>
                        <select name="month" class="form-control" style="width: auto; padding: 8px 32px 8px 14px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; color: #fff; font-size: 14px; outline: none; cursor: pointer; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'white\' viewBox=\'0 0 16 16\'><path d=\'M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z\'/></svg>'); background-repeat: no-repeat; background-position: right 10px center;" onchange="this.form.submit()">
                            @php
                                $months = ['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'];
                                $selectedMonth = request('month', date('m'));
                            @endphp
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}" style="background: #1a1d24; color: #fff;" {{ $selectedMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        
                        <select name="year" class="form-control" style="width: auto; padding: 8px 32px 8px 14px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; color: #fff; font-size: 14px; outline: none; cursor: pointer; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'white\' viewBox=\'0 0 16 16\'><path d=\'M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z\'/></svg>'); background-repeat: no-repeat; background-position: right 10px center;" onchange="this.form.submit()">
                            @php
                                $currentYear = date('Y');
                                $selectedYear = request('year', $currentYear);
                            @endphp
                            @for($y = $currentYear + 1; $y >= 2023; $y--)
                                <option value="{{ $y }}" style="background: #1a1d24; color: #fff;" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </form>
                    <a href="{{ route('admin.stock.export', ['month' => request('month', date('m')), 'year' => request('year', date('Y'))]) }}" class="btn-export-pdf">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            EKSPOR PDF
                        </a>
                    </div>
                </div>

                {{-- ═══════ DATA TABLE ═══════ --}}
                <div class="adm-table-container">
                    <div class="adm-table-scroller">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">ID</th>
                                    <th>ITEM</th>
                                    <th>MASUK</th>
                                    <th>KELUAR</th>
                                    <th>SISA STOK</th>
                                    <th>TANGGAL</th>
                                    <th>CATATAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $index => $transaction)
                                    <tr>
                                        <td>{{ $transactions->firstItem() + $index }}</td>
                                        <td style="font-weight: 700; color: #00e5ff;">{{ $transaction->menu->name }}</td>
                                        <td style="font-weight: 700; color: #2ed573;">
                                            @if($transaction->type === 'in')
                                                {{ $transaction->quantity }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td style="font-weight: 700; color: #ff5252;">
                                            @if($transaction->type === 'out')
                                                {{ $transaction->quantity }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $sisaStok = \App\Models\StockTransaction::where('menu_id', $transaction->menu_id)
                                                    ->where('id', '<=', $transaction->id)
                                                    ->sum(\Illuminate\Support\Facades\DB::raw("CASE WHEN type = 'in' THEN quantity ELSE -quantity END"));
                                            @endphp
                                            <span style="font-weight: 800; color: #fff;">{{ $sisaStok }}</span>
                                        </td>
                                        <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                        <td style="color: rgba(255,255,255,0.5);">{{ $transaction->note ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" style="text-align: center; padding: 60px; color: rgba(255,255,255,0.1);">Belum ada riwayat transaksi stok.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $transactions->links('component.c_dashboard.pagination') }}
                </div>

            </div>
        </main>
    </div>

    {{-- Logout Modal --}}
    @include('component.c_dashboard.modal.logout_modal')
    <script src="{{ asset('js/js_component/logout.js') }}"></script>
</body>
</html>
