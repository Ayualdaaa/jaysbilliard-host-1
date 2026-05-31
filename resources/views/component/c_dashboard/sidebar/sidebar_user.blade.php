{{-- ═══════════ SIDEBAR USER ═══════════ --}}
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
                <span class="adm-brand-sub">USER DASHBOARD</span>
            </div>
            <button class="adm-collapse-btn" id="sidebarToggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="11 17 6 12 11 7"></polyline>
                    <polyline points="18 17 13 12 18 7"></polyline>
                </svg>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="adm-nav">
            <a href="{{ route('dashboard') }}" class="adm-nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1" />
                    <rect width="7" height="5" x="14" y="3" rx="1" />
                    <rect width="7" height="9" x="14" y="12" rx="1" />
                    <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('user.meja') }}"
                class="adm-nav-link {{ Request::is('dashboard/meja*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v3H3V8Z" />
                    <path d="M6 11v9" />
                    <path d="M18 11v9" />
                    <path d="M6 15h12" />
                </svg>
                <span>Pemesanan Meja</span>
            </a>
            <a href="{{ route('user.fnb') }}" class="adm-nav-link {{ Request::is('dashboard/fnb*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2" />
                    <path d="M7 2v20" />
                    <path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7" />
                </svg>
                <span>Pemesanan F&B</span>
            </a>
            <a href="{{ route('user.history') }}"
                class="adm-nav-link {{ Request::is('dashboard/history*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                <span>Riwayat Pesanan</span>
            </a>
        </nav>
    </div>

    {{-- Logout --}}
    <div class="adm-sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST" id="logout-sidebar-form">
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

{{-- REAL-TIME USER NOTIFICATION SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let notifiedKeys = [];
        const notificationSound = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');

        // Format date for notification display
        function formatDate(dateStr) {
            const date = new Date(dateStr);
            const options = { day: 'numeric', month: 'short' };
            return date.toLocaleDateString('id-ID', options);
        }

        function checkUserNotifications() {
            fetch('{{ route("user.notifications.check") }}')
                .then(response => response.json())
                .then(data => {
                    if (!data.success || !data.notifications || data.notifications.length === 0) {
                        return;
                    }

                    // Get read keys from localStorage
                    let readKeys = [];
                    try {
                        readKeys = JSON.parse(localStorage.getItem('user_read_notification_keys')) || [];
                    } catch (e) {
                        readKeys = [];
                    }

                    let unreadCount = 0;
                    const notifContent = document.getElementById('notifListContent');
                    const badge = document.getElementById('notif-badge-count');

                    if (notifContent) {
                        notifContent.innerHTML = ''; // Clear empty state
                    }

                    let playSound = false;
                    let newlyUpdatedNotifs = [];

                    // Track all keys fetched in this check
                    let currentKeys = [];

                    data.notifications.forEach(n => {
                        let key = `${n.type}-${n.id}-${n.status}`;
                        currentKeys.push(key);

                        let isUnread = !readKeys.includes(key);

                        if (isUnread) {
                            unreadCount++;
                        }

                        // Check if we should notify (sound/toast)
                        // We notify if it is unread AND we haven't played a sound for this key in the current session
                        if (isUnread && !notifiedKeys.includes(key)) {
                            notifiedKeys.push(key);

                            // Only trigger toast/sound for items updated in the last 1 minute or if this isn't the initial session load
                            // to avoid spamming the user on page refresh.
                            let itemTime = new Date(n.updated_at);
                            let isRecent = (new Date() - itemTime) < 60000;
                            if (isRecent || notifiedKeys.length > 1) {
                                newlyUpdatedNotifs.push(n);
                                playSound = true;
                            }
                        }

                        // Build UI elements
                        let title = '';
                        let description = '';
                        let statusColor = '';
                        let iconSvg = '';
                        let dotIndicator = isUnread ? `<span class="unread-dot" style="width: 8px; height: 8px; background: ${n.type === 'booking' ? '#00e5ff' : '#ffb300'}; border-radius: 50%; margin-left: 10px; flex-shrink: 0;"></span>` : '';
                        let borderLeftColor = n.type === 'booking' ? '#00e5ff' : '#ffb300';
                        let unreadBg = isUnread ? `background: rgba(${n.type === 'booking' ? '0,229,255' : '255,179,0'}, 0.04);` : '';

                        if (n.type === 'booking') {
                            statusColor = '#00e5ff';
                            iconSvg = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>`;
                            const tableName = n.table ? n.table.name : 'Meja';

                            switch (n.status.toLowerCase()) {
                                case 'pending':
                                    title = 'Booking Meja Dibuat';
                                    description = `Booking ${tableName} pada ${formatDate(n.booking_date)} pukul ${n.start_time.substring(0, 5)} - ${n.end_time.substring(0, 5)} menunggu pembayaran.`;
                                    break;
                                case 'booked':
                                case 'confirmed':
                                    title = 'Booking Meja Berhasil!';
                                    description = `Pesanan ${tableName} Anda telah berhasil dikonfirmasi untuk bermain pada ${formatDate(n.booking_date)}!`;
                                    break;
                                case 'completed':
                                    title = 'Sesi Bermain Selesai';
                                    description = `Terima kasih telah bermain di ${tableName}. Sampai jumpa kembali!`;
                                    break;
                                case 'cancelled':
                                    title = 'Booking Dibatalkan';
                                    description = `Booking ${tableName} pada ${formatDate(n.booking_date)} telah dibatalkan.`;
                                    break;
                                default:
                                    title = 'Booking Meja Diperbarui';
                                    description = `Status booking ${tableName} Anda diperbarui menjadi ${n.status}.`;
                            }
                        } else {
                            statusColor = '#ffb300';
                            iconSvg = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>`;
                            const tableName = (n.booking && n.booking.table) ? n.booking.table.name : '';
                            const tableInfo = tableName ? ` (Meja ${tableName})` : '';

                            switch (n.status.toLowerCase()) {
                                case 'pending':
                                    title = 'Pesanan F&B Dibuat';
                                    description = `Pesanan F&B${tableInfo}: ${n.items_summary} menunggu pembayaran.`;
                                    break;
                                case 'paid':
                                case 'success':
                                    title = 'Pesanan F&B Berhasil!';
                                    description = `Pembayaran pesanan F&B${tableInfo}: ${n.items_summary} berhasil dan sedang diproses.`;
                                    break;
                                case 'completed':
                                    title = 'Pesanan F&B Selesai';
                                    description = `Pesanan F&B${tableInfo}: ${n.items_summary} telah disajikan. Selamat menikmati!`;
                                    break;
                                case 'cancelled':
                                case 'expired':
                                    title = 'Pesanan F&B Dibatalkan';
                                    description = `Pesanan F&B${tableInfo}: ${n.items_summary} telah dibatalkan.`;
                                    break;
                                default:
                                    title = 'Pesanan F&B Diperbarui';
                                    description = `Pesanan F&B Anda diperbarui menjadi ${n.status}.`;
                            }
                        }

                        if (notifContent) {
                            notifContent.innerHTML += `
                                <div class="notif-item ${n.type} ${isUnread ? 'unread' : ''}" data-key="${key}" style="border-left: 3px solid ${borderLeftColor}; margin-bottom: 8px; padding: 10px; border-radius: 8px; transition: background 0.2s; ${unreadBg}">
                                    <div style="display: flex; gap: 10px; align-items: flex-start;">
                                        <div style="background: rgba(${n.type === 'booking' ? '0,229,255' : '255,179,0'}, 0.1); color: ${statusColor}; padding: 8px; border-radius: 8px; margin-top: 2px;">
                                            ${iconSvg}
                                        </div>
                                        <div style="flex: 1;">
                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 5px;">
                                                <div style="font-size: 0.8rem; font-weight: 700; color: #fff; line-height: 1.2;">${title}</div>
                                                ${dotIndicator}
                                            </div>
                                            <div style="font-size: 0.7rem; color: #aaa; margin-top: 3px; line-height: 1.3;">${description}</div>
                                            <div style="font-size: 0.65rem; color: #666; margin-top: 4px;">${n.time_ago}</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    });

                    // Store currentKeys globally to reference during read triggers
                    window.latestNotifKeys = currentKeys;

                    // Populate Badge Count
                    if (badge) {
                        if (unreadCount > 0) {
                            badge.innerText = unreadCount;
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    }

                    // Play Sound and Show Toast for newly updated notifications
                    if (playSound && newlyUpdatedNotifs.length > 0) {
                        notificationSound.play().catch(e => console.log('Audio play blocked'));

                        newlyUpdatedNotifs.forEach(n => {
                            // Trigger Toast
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 6000,
                                timerProgressBar: true,
                                background: '#141418',
                                color: '#fff',
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            let toastTitle = '';
                            let toastIcon = 'info';
                            let toastText = '';

                            if (n.type === 'booking') {
                                const tableName = n.table ? n.table.name : 'Meja';
                                if (n.status.toLowerCase() === 'booked' || n.status.toLowerCase() === 'confirmed') {
                                    toastIcon = 'success';
                                    toastTitle = `Booking ${tableName} Berhasil!`;
                                    toastText = 'Pesanan Anda telah dikonfirmasi.';
                                } else if (n.status.toLowerCase() === 'completed') {
                                    toastIcon = 'info';
                                    toastTitle = `Sesi ${tableName} Selesai`;
                                    toastText = 'Terima kasih telah bermain di Jay\'s Billiard.';
                                } else if (n.status.toLowerCase() === 'cancelled') {
                                    toastIcon = 'error';
                                    toastTitle = `Booking ${tableName} Dibatalkan`;
                                    toastText = 'Booking Anda telah dibatalkan.';
                                }
                            } else {
                                if (n.status.toLowerCase() === 'paid' || n.status.toLowerCase() === 'success') {
                                    toastIcon = 'success';
                                    toastTitle = 'Pesanan F&B Berhasil!';
                                    toastText = 'Sajian Anda sedang dipersiapkan.';
                                } else if (n.status.toLowerCase() === 'completed') {
                                    toastIcon = 'success';
                                    toastTitle = 'Pesanan F&B Selesai';
                                    toastText = 'Pesanan Anda telah disajikan.';
                                } else if (n.status.toLowerCase() === 'cancelled') {
                                    toastIcon = 'error';
                                    toastTitle = 'Pesanan F&B Dibatalkan';
                                    toastText = 'Pemesanan makanan Anda dibatalkan.';
                                }
                            }

                            if (toastTitle) {
                                Toast.fire({
                                    icon: toastIcon,
                                    title: toastTitle,
                                    text: toastText,
                                    confirmButtonColor: '#00e5ff'
                                });
                            }
                        });
                    }
                })
                .catch(error => console.error('Error checking notifications:', error));
        }

        // Mark all current notifications as read and persist to localStorage
        function markAllAsRead() {
            if (!window.latestNotifKeys || window.latestNotifKeys.length === 0) {
                return;
            }

            let readKeys = [];
            try {
                readKeys = JSON.parse(localStorage.getItem('user_read_notification_keys')) || [];
            } catch (e) {
                readKeys = [];
            }

            // Merge current keys
            window.latestNotifKeys.forEach(k => {
                if (!readKeys.includes(k)) {
                    readKeys.push(k);
                }
            });

            // Persist read states
            localStorage.setItem('user_read_notification_keys', JSON.stringify(readKeys));

            // Clear badge
            const badge = document.getElementById('notif-badge-count');
            if (badge) {
                badge.style.display = 'none';
                badge.innerText = '0';
            }

            // Remove unread indicators immediately from the dropdown view
            const unreadDots = document.querySelectorAll('#notifDropdown .unread-dot');
            unreadDots.forEach(dot => dot.style.display = 'none');

            const unreadItems = document.querySelectorAll('.notif-item.unread');
            unreadItems.forEach(item => {
                item.classList.remove('unread');
                item.style.background = 'transparent';
            });
        }

        // Click listener for the notification bell
        const bellBtn = document.getElementById('notifBellBtn');
        if (bellBtn) {
            bellBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                markAllAsRead();
            });
        }

        // Click listener for the mark all read button
        const markAllBtn = document.getElementById('markAllReadBtn');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                markAllAsRead();
            });
        }

        // Check every 10 seconds
        setInterval(checkUserNotifications, 10000);

        // Initial check
        checkUserNotifications();
    });
</script>