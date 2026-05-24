{{-- Top Bar --}}
<header class="adm-topbar">
    <div class="adm-topbar-left">
        <button type="button" class="mobile-menu-btn" id="mobileMenuBtn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
        <div>
            <h1 class="adm-topbar-title">{{ $topbar_title ?? 'Dashboard' }}</h1>
            <p class="adm-topbar-sub">{{ $topbar_sub ?? "Kelola kebutuhan operasional jay's billiard" }}</p>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/css_page/css_interaksi component/profile_dropdown.css') }}">
    <div class="adm-topbar-right" style="display: flex; align-items: center; gap: 20px;">
        @if(isset($topbar_right))
            {!! $topbar_right !!}
        @else
            {{-- Notification Bell --}}
            <div class="adm-notif-bell-wrap" style="position: relative;">
                <div class="adm-notif-bell-btn" id="notifBellBtn" style="color: #666; transition: all 0.3s ease; cursor: pointer; padding: 5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span id="notif-badge-count" style="display: none; position: absolute; top: 0px; right: 0px; background: #ff5252; color: white; font-size: 9px; font-weight: bold; width: 16px; height: 16px; border-radius: 50%; justify-content: center; align-items: center; border: 2px solid #141418;">0</span>
                </div>

                {{-- NOTIFICATION DROPDOWN --}}
                <div id="notifDropdown" style="display: none; position: absolute; top: 45px; right: 0; width: 320px; background: #1a1a1e; border: 1px solid #333; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); z-index: 1000; padding: 15px; color: #fff;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #333; padding-bottom: 10px;">
                        <span style="font-weight: 700; font-size: 0.9rem;">Notifikasi Baru</span>
                        <span id="markAllReadBtn" style="font-size: 0.75rem; color: #00e5ff; cursor: pointer;">Tandai semua dibaca</span>
                    </div>
                    
                    <div id="notifListContent" style="max-height: 350px; overflow-y: auto;">
                        {{-- Content will be injected by JS --}}
                        <div style="text-align: center; padding: 20px; color: #666; font-size: 0.8rem;">Tidak ada pesanan baru</div>
                    </div>

                    <a href="{{ (auth()->check() && auth()->user()->role === 'admin') ? route('admin.history') : route('user.history') }}" style="display: block; text-align: center; margin-top: 15px; padding-top: 10px; border-top: 1px solid #333; color: #00e5ff; font-size: 0.8rem; text-decoration: none; font-weight: 600;">Lihat Semua Riwayat</a>
                </div>
            </div>

            <style>
                .notif-item { padding: 10px; border-radius: 8px; margin-bottom: 8px; transition: background 0.2s; border-left: 3px solid transparent; }
                .notif-item:hover { background: rgba(255,255,255,0.05); }
                .notif-item.booking { border-left-color: #00e5ff; }
                .notif-item.order { border-left-color: #ffb300; }
                #notifDropdown::-webkit-scrollbar { width: 5px; }
                #notifDropdown::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
            </style>

            <script>
                document.getElementById('notifBellBtn').addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdown = document.getElementById('notifDropdown');
                    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
                });
                document.addEventListener('click', function() {
                    const dropdown = document.getElementById('notifDropdown');
                    if (dropdown) dropdown.style.display = 'none';
                });
                document.getElementById('notifDropdown').addEventListener('click', (e) => e.stopPropagation());


            </script>

            <div class="adm-user-profile-wrap">
                <div class="adm-user-badge" id="profileBtn">
                    <div class="adm-user-avatar">A</div>
                    <span class="adm-user-name">{{ (Request::is('admin*') || Request::is('admin-dashboard*')) ? 'Admin' : (auth()->user()->name ?? 'User') }}</span>
                    <svg class="badge-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
                @include('component.c_dashboard.dropdown.profile_acount')
            </div>
        @endif
    </div>
</header>

<script src="{{ asset('js/js_component/profile_dropdown.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const sidebar = document.querySelector('.adm-sidebar');
                if (sidebar) {
                    sidebar.classList.toggle('mobile-open');
                    
                    let overlay = document.querySelector('.mobile-overlay');
                    if (!overlay) {
                        overlay = document.createElement('div');
                        overlay.className = 'mobile-overlay';
                        document.body.appendChild(overlay);
                        
                        overlay.addEventListener('click', function() {
                            sidebar.classList.remove('mobile-open');
                            overlay.classList.remove('active');
                        });
                    }
                    
                    if (sidebar.classList.contains('mobile-open')) {
                        overlay.classList.add('active');
                    } else {
                        overlay.classList.remove('active');
                    }
                }
            });
        }
    });
</script>