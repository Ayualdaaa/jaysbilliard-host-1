<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Kelola Akun — Jay's Billiard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/css_layout/app_admin.css') }}">
    
    <style>
        .adm-akun-content { padding: 0 2rem 2rem; }
        .adm-akun-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .adm-akun-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .adm-search-wrap {
            position: relative;
            display: flex;
            align-items: center;
            background: #111418;
            border: 1.5px solid rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 0 1rem;
            width: 300px;
        }
        .adm-search-icon { color: rgba(255,255,255,0.4); margin-right: 0.5rem; }
        .adm-search-input {
            background: transparent;
            border: none;
            color: #fff;
            padding: 0.85rem 0;
            width: 100%;
            outline: none;
            font-size: 0.9rem;
        }
        .adm-btn-add {
            background: #00e5ff;
            color: #000;
            text-decoration: none;
            padding: 0.85rem 1.5rem;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }
        .adm-btn-add:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0, 229, 255, 0.25); }

        .adm-table-wrapper {
            background: #111418;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 20px;
            overflow: hidden;
        }
        .adm-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .adm-table th {
            padding: 1.25rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 800;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            background: rgba(255,255,255,0.02);
        }
        .adm-table td {
            padding: 1.25rem 1.5rem;
            font-size: 0.9rem;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .adm-table tr:hover td { background: rgba(255,255,255,0.02); }
        .adm-table tr:last-child td { border-bottom: none; }

        .role-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-block;
        }
        .role-admin { background: rgba(0, 229, 255, 0.1); color: #00e5ff; border: 1px solid rgba(0, 229, 255, 0.2); }
        .role-user { background: rgba(0, 229, 255, 0.1); color: #00e5ff; border: 1px solid rgba(0, 229, 255, 0.2); }

        .action-btns {
            display: flex;
            gap: 0.5rem;
        }
        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-action:hover { background: #fff; color: #000; }
        .btn-action.delete:hover { background: #ff3b3b; color: #fff; }

        .user-info { display: flex; align-items: center; gap: 1rem; }
        .user-avatar {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.05);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #00e5ff; font-size: 1.1rem;
        }
        .user-name-col { display: flex; flex-direction: column; gap: 0.2rem; }
        .user-name { font-weight: 800; color: #fff; }
        .user-email { font-size: 0.75rem; color: rgba(255,255,255,0.5); }

        /* Pagination Styles */
        nav[role="navigation"] {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
        }
        nav[role="navigation"] > div:first-child {
            display: none;
        }
        nav[role="navigation"] > div:last-child {
            display: flex;
            width: 100%;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
        nav[role="navigation"] p {
            color: rgba(255,255,255,0.5);
            font-size: 0.85rem;
            margin: 0;
            text-align: center;
        }
        nav[role="navigation"] .relative.z-0.inline-flex {
            display: flex;
            gap: 0.5rem;
            background: #111418;
            padding: 0.5rem;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.05);
        }
        nav[role="navigation"] a, nav[role="navigation"] span[aria-disabled="true"], nav[role="navigation"] span[aria-current="page"] > span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 0.5rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            color: rgba(255,255,255,0.7) !important;
            transition: all 0.2s;
            background: transparent;
            border: none;
            box-shadow: none !important;
            ring: none !important;
        }
        nav[role="navigation"] a:hover {
            background: rgba(255,255,255,0.1);
            color: #fff !important;
        }
        nav[role="navigation"] span[aria-current="page"] > span {
            background: #00e5ff;
            color: #000 !important;
        }
        nav[role="navigation"] span[aria-disabled="true"] {
            opacity: 0.3;
            cursor: not-allowed;
            color: rgba(255,255,255,0.3) !important;
        }
        nav[role="navigation"] svg {
            width: 18px;
            height: 18px;
        }
    </style>
</head>
<body>
    <div class="adm-layout">
        @include('component.c_dashboard.sidebar.sidebar_admin')

        <main class="adm-main">
            @include('component.c_dashboard.topbar.topbar', [
                'topbar_title' => 'Kelola Akun',
                'topbar_sub' => 'Manajemen role dan akses pengguna'
            ])

            <div class="adm-content adm-akun-content">
                @if(session('success'))
                    <div class="adm-alert adm-alert--success" style="margin-bottom: 2rem;">
                        <div class="adm-alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 12 2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg>
                        </div>
                        <div class="adm-alert-content">
                            <span class="adm-alert-title">Berhasil!</span>
                            <span class="adm-alert-msg">{{ session('success') }}</span>
                        </div>
                        <button class="adm-alert-close" onclick="this.parentElement.style.display='none'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="adm-alert adm-alert--error" style="margin-bottom: 2rem; background: rgba(255, 59, 59, 0.1); border: 1px solid rgba(255, 59, 59, 0.2); border-radius: 12px; padding: 15px; display: flex; align-items: center; gap: 15px;">
                        <div style="color: #ff3b3b;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 800; color: #ff3b3b; font-size: 0.95rem;">Gagal!</div>
                            <div style="font-size: 0.85rem; color: rgba(255,255,255,0.7); margin-top: 2px;">{{ session('error') }}</div>
                        </div>
                        <button onclick="this.parentElement.style.display='none'" style="background: none; border: none; color: rgba(255,255,255,0.5); cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg></button>
                    </div>
                @endif

                <div class="adm-akun-header">
                    <div class="adm-search-wrap">
                        <svg class="adm-search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" class="adm-search-input" id="searchUser" placeholder="Cari nama, username, atau email...">
                    </div>
                    <div class="adm-akun-actions">
                        <a href="{{ route('admin.akun.create') }}" class="adm-btn-add">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            BUAT AKUN
                        </a>
                    </div>
                </div>

                <div class="adm-table-wrapper">
                    <table class="adm-table" id="usersTable">
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Username</th>
                                <th>No. Telepon</th>
                                <th>Role</th>
                                <th>Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="user-row">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                        <div class="user-name-col">
                                            <span class="user-name">{{ $user->name }}</span>
                                            <span class="user-email">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-family: monospace; color: rgba(255,255,255,0.7);">{{ $user->username }}</td>
                                <td>{{ $user->phone ?: '-' }}</td>
                                <td>
                                    <span class="role-badge role-{{ $user->role }}">{{ $user->role }}</span>
                                </td>
                                <td style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('admin.akun.edit', $user->id) }}" class="btn-action">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.akun.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action delete" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                            </button>
                                        </form>
                                        @else
                                        <button class="btn-action" disabled style="opacity:0.3; cursor:not-allowed;" title="Tidak dapat menghapus akun sendiri">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
                    {{ $users->links() }}
                </div>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('searchUser').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.user-row');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
    </script>
    
    {{-- Logout Modal --}}
    @include('component.c_dashboard.modal.logout_modal')
    <script src="{{ asset('js/js_component/logout.js') }}"></script>
</body>
</html>
