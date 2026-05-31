{{-- ═══════════ SIDEBAR ═══════════ --}}
<aside class="adm-sidebar">
    <div class="adm-sidebar-top">
        {{-- Brand --}}
        <div class="adm-brand">
            <div class="adm-brand-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path d="M7 8h10" />
                    <path d="M7 12h10" />
                    <path d="M7 16h6" />
                </svg>
            </div>
            <div class="adm-brand-text">
                <span class="adm-brand-name">Jay's Billiard</span>
                <span class="adm-brand-sub">ADMIN DASHBOARD</span>
            </div>
            <button class="adm-collapse-btn" id="sidebarToggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="adm-nav">
            <a href="{{ url('/admin-dashboard') }}"
                class="adm-nav-link {{ Request::is('admin-dashboard*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.history') }}"
                class="adm-nav-link {{ Request::is('admin/history*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1" />
                    <line x1="9" y1="12" x2="15" y2="12" />
                    <line x1="9" y1="16" x2="15" y2="16" />
                </svg>
                <span>History Pemesanan</span>
            </a>
            <a href="{{ route('admin.meja.index') }}"
                class="adm-nav-link {{ Request::is('admin/meja*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="4" rx="1" />
                    <path d="M4 11v7" />
                    <path d="M20 11v7" />
                    <path d="M9 11v3" />
                    <path d="M15 11v3" />
                </svg>
                <span>Kelola Meja</span>
            </a>
            <a href="{{ route('admin.menu') }}" class="adm-nav-link {{ Request::is('admin/menu*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2" />
                    <path d="M7 2v20" />
                    <path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7" />
                </svg>
                <span>Kelola Pemesanan </span>
            </a>
            <a href="{{ route('admin.stock.index') }}"
                class="adm-nav-link {{ Request::is('admin/stock*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                    <path d="m3.3 7 8.7 5 8.7-5" />
                    <path d="M12 22V12" />
                </svg>
                <span>Kelola Stok </span>
            </a>
            <a href="{{ route('admin.akun.index') }}"
                class="adm-nav-link {{ Request::is('admin/akun*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                <span>Kelola Akun</span>
            </a>
            <a href="{{ route('admin.laporan') }}"
                class="adm-nav-link {{ Request::is('admin/laporan*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
                <span>Laporan Penghasilan</span>
            </a>
        </nav>
    </div>

    {{-- Logout --}}
    <div class="adm-sidebar-bottom">
        <form action="{{ route('admin.logout') }}" method="POST" id="logout-sidebar-form">
            @csrf
            <button type="button" class="adm-logout-btn adm-logout-trigger"
                onclick="window.confirmLogout(event, this.form)"
                style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>
    {{-- REAL-TIME NOTIFICATION SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let lastTotal = 0;
            const notificationSound = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');

            function checkNewOrders() {
                fetch('{{ route("admin.notifications.check") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.total_new > 0 && data.total_new > lastTotal) {
                            // Play Sound
                            notificationSound.play().catch(e => console.log('Audio play blocked'));

                            // Show Toast
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                background: '#141418',
                                color: '#fff',
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            let msg = '';
                            if (data.new_bookings > 0) msg += `${data.new_bookings} Pesanan Meja Baru! `;
                            if (data.new_orders > 0) msg += `${data.new_orders} Pesanan F&B Baru!`;

                            Toast.fire({
                                icon: 'info',
                                title: 'Pesanan Masuk!',
                                text: msg,
                                confirmButtonColor: '#00e5ff'
                            });

                            // Update Topbar Badge
                            const badge = document.getElementById('notif-badge-count');
                            const notifContent = document.getElementById('notifListContent');

                            if (badge) {
                                badge.innerText = data.total_new;
                                badge.style.display = 'flex';
                                badge.animate([{ transform: 'scale(1)' }, { transform: 'scale(1.4)' }, { transform: 'scale(1)' }], { duration: 300 });
                            }

                            if (notifContent && data.notifications.length > 0) {
                                notifContent.innerHTML = ''; // Clear empty state

                                data.notifications.forEach(n => {
                                    if (n.type === 'booking') {
                                        notifContent.innerHTML += `
                                            <div class="notif-item booking">
                                                <div style="display: flex; gap: 10px; align-items: center;">
                                                    <div style="background: rgba(0,229,255,0.1); color: #00e5ff; padding: 8px; border-radius: 8px;">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <div style="font-size: 0.8rem; font-weight: 700; color: #fff;">${n.customer_name}</div>
                                                        <div style="font-size: 0.7rem; color: #00e5ff;">Pesan ${n.table ? n.table.name : 'Meja'}</div>
                                                        <div style="font-size: 0.65rem; color: #666; margin-top: 2px;">Baru saja</div>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                    } else {
                                        notifContent.innerHTML += `
                                            <div class="notif-item order">
                                                <div style="display: flex; gap: 10px; align-items: flex-start;">
                                                    <div style="background: rgba(255,179,0,0.1); color: #ffb300; padding: 8px; border-radius: 8px; margin-top: 3px;">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <div style="font-size: 0.8rem; font-weight: 700; color: #fff;">Pesanan F&B ${n.booking && n.booking.table ? '(' + n.booking.table.name + ')' : ''}</div>
                                                        <div style="font-size: 0.7rem; color: #ffb300; font-weight: 600;">${n.items_summary}</div>
                                                        <div style="font-size: 0.7rem; color: #aaa; margin-top: 2px;">Total: Rp ${new Intl.NumberFormat('id-ID').format(n.total_price_fnb)}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                    }
                                });
                            }

                            // Optionally refresh specific parts of the UI if on history/dashboard
                            if (window.location.pathname.includes('/admin/history') || window.location.pathname.includes('/admin-dashboard')) {
                                // You could trigger a soft refresh or reload
                                // location.reload(); // Too aggressive, maybe just update stats
                            }
                        }
                        lastTotal = data.total_new;
                    })
                    .catch(error => console.error('Error checking notifications:', error));
            }

            // Check every 10 seconds
            setInterval(checkNewOrders, 10000);

            // Initial check
            checkNewOrders();
        });
    </script>
</aside>
<script>
    const sidebar = document.querySelector('.adm-sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');

    // Check initial state
    if (localStorage.getItem('sidebar-collapsed') === 'true') {
        sidebar.classList.add('collapsed');
    }

    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
    });
</script>
<script src="{{ asset('js/js_component/mobile_menu.js') }}"></script>