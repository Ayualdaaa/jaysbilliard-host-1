<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow, noarchive">
    <title>@yield('title', "Dashboard — Jay's Billiard")</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/css_layout/app_admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css_page/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css_page/css_interaksi component/chat.css') }}">
    @stack('styles')

    {{-- SweetAlert2 for premium feedback --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        /**
         * Global Avatar Loader
         */
        function loadGlobalAvatar() {
            const isAdmin = {{ auth()->check() && auth()->user()->role === 'admin' ? 'true' : 'false' }};
            const avatarKey = isAdmin ? 'admin_avatar' : 'user_avatar';
            const savedAvatar = localStorage.getItem(avatarKey);
            if (savedAvatar) {
                const avatars = document.querySelectorAll('.adm-user-avatar, .ps-avatar-circle');
                avatars.forEach(avatar => {
                    avatar.innerHTML = `<img src="${savedAvatar}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;
                });
            }
        }

        document.addEventListener('DOMContentLoaded', loadGlobalAvatar);
    </script>
    <script src="{{ asset('js/js_component/logout.js') }}"></script>
    <style>
        @keyframes pulseBadge {
            0% { transform: scale(1); }
            50% { transform: scale(1.25); box-shadow: 0 0 12px #ff3b3b; }
            100% { transform: scale(1); }
        }
        .pulse-badge {
            animation: pulseBadge 1.5s infinite alternate;
        }
    </style>
</head>
<body>
    <div class="adm-layout">
        {{-- Sidebar --}}
        @if(Request::is('admin*') || Request::is('admin-dashboard*'))
            @include('component.c_dashboard.sidebar.sidebar_admin')
        @else
            @include('component.c_dashboard.sidebar.sidebar_user')
        @endif

        {{-- Main Content --}}
        <main class="adm-main">
            {{-- Top Bar --}}
            @if(!Route::is('admin.profile') && !Route::is('user.profile'))
                @include('component.c_dashboard.topbar.topbar', [
                    'topbar_title' => $topbar_title ?? 'Dashboard',
                    'topbar_sub' => $topbar_sub ?? "Kelola kebutuhan operasional jay's billiard"
                ])
            @endif

            {{-- Page Content --}}
            <div class="adm-content">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Modal Components --}}
    @include('component.c_dashboard.modal.logout_modal')

    @if(auth()->check() && auth()->user()->role !== 'admin')
        @php
            $userActiveBooking = \App\Models\Booking::where('customer_name', auth()->user()->name)
                ->whereIn('status', ['confirmed', 'booked', 'pending', 'dipesan', 'paid', 'lunas'])
                ->latest('updated_at')
                ->first();
            $defaultTableId = $userActiveBooking ? $userActiveBooking->table_id : 1;
            
            $tablesMap = \App\Models\Table::all()->mapWithKeys(function($table) {
                $todayStr = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                $activeBooking = $table->bookings->filter(function($b) use ($todayStr) {
                    if ($b->booking_date !== $todayStr) return false;
                    $nowTime = \Carbon\Carbon::now('Asia/Jakarta');
                    $nowFloat = $nowTime->hour + ($nowTime->minute / 60);
                    $startParts = explode(':', $b->start_time);
                    $startFloat = intval($startParts[0]) + (intval($startParts[1]) / 60);
                    $endParts = explode(':', $b->end_time);
                    $endFloat = intval($endParts[0]) + (intval($endParts[1]) / 60);
                    return $nowFloat >= $startFloat && $nowFloat < $endFloat;
                })->first();

                $statusText = 'TERSEDIA';
                $statusColor = '#00e5ff';
                if ($table->status === 'maintenance') {
                    $statusText = 'MAINTENANCE';
                    $statusColor = '#ff3b3b';
                } elseif ($activeBooking) {
                    $statusLower = strtolower($activeBooking->status);
                    if ($statusLower === 'confirmed') {
                        $statusText = 'TERISI';
                        $statusColor = '#ff3b3b';
                    } elseif (in_array($statusLower, ['pending', 'booked', 'dipesan', 'paid', 'lunas'])) {
                        $statusText = 'DIPESAN';
                        $statusColor = '#ffab00';
                    }
                }

                return [$table->id => [
                    'name' => $table->name,
                    'status' => $statusText,
                    'color' => $statusColor
                ]];
            });
        @endphp



        {{-- Chat Popup Component --}}
        @include('component.c_dashboard.modal.chat_blade')

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tablesMetadata = @json($tablesMap);
                const defaultTableId = {{ $defaultTableId }};

                const chatOverlay = document.getElementById('chatOverlay');
                const chatPopup = document.getElementById('chatPopup');
                const chatCloseBtn = document.getElementById('chatClose');
                const chatBody = document.getElementById('chatBody');
                const chatInput = document.getElementById('chatInput');
                const chatSendBtn = document.getElementById('chatSend');

                let userChatData = JSON.parse(localStorage.getItem('billiard_chat_history'));
                if (!userChatData) {
                    userChatData = {
                        1: { table: 'MEJA 01', status: 'TERISI', statusColor: '#00e5ff', user: 'Rian S.', messages: [] },
                        2: { table: 'MEJA 02', status: 'TERSEDIA', statusColor: '#00e5ff', user: 'System', messages: [] },
                        3: { table: 'MEJA 03', status: 'DIPESAN', statusColor: '#ffab00', user: 'Zaenal', messages: [] },
                        4: { table: 'MEJA 04', status: 'TERISI', statusColor: '#00e5ff', user: 'Haecan', messages: [] }
                    };
                    localStorage.setItem('billiard_chat_history', JSON.stringify(userChatData));
                }

                // Periodic Database Sync
                function syncChatWithDatabase() {
                    fetch('{{ route("chat.sync") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ history: userChatData })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success && res.history) {
                            userChatData = res.history;
                            localStorage.setItem('billiard_chat_history', JSON.stringify(userChatData));
                            updateUserBadges();
                            
                            const activeId = chatPopup.dataset.activeTableId;
                            if (activeId && chatPopup.classList.contains('active')) {
                                renderUserMessages(activeId);
                            }
                        }
                    })
                    .catch(err => console.error('Database chat sync error:', err));
                }

                function markTableAsRead(id) {
                    fetch(`/chat/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            if (userChatData[id]) {
                                userChatData[id].hasUnreadForUser = false;
                                localStorage.setItem('billiard_chat_history', JSON.stringify(userChatData));
                                updateUserBadges();
                            }
                        }
                    })
                    .catch(err => console.error('Mark read error:', err));
                }

                function updateUserBadges() {
                    // Update table list card chat badges if on meja page
                    const cardChatBtns = document.querySelectorAll('.tm-btn-chat');
                    cardChatBtns.forEach(btn => {
                        const parentTable = btn.closest('.billiard-table');
                        if (parentTable) {
                            const id = parentTable.dataset.id;
                            let badge = btn.querySelector('.notif-badge');
                            if (userChatData[id] && userChatData[id].hasUnreadForUser) {
                                if (badge) badge.style.display = 'flex';
                            } else {
                                if (badge) badge.style.display = 'none';
                            }
                        }
                    });
                }

                function renderUserMessages(id) {
                    chatBody.innerHTML = '';
                    const messages = userChatData[id] ? userChatData[id].messages : [];
                    if (messages.length === 0) {
                        const welcomeWrapper = document.createElement('div');
                        welcomeWrapper.className = 'chat-msg chat-msg--customer'; // left side (admin)
                        welcomeWrapper.innerHTML = `
                            <div class="chat-bubble">Halo, ada yang bisa kami bantu mengenai meja ini?</div>
                            <div class="chat-meta">System &bull; Now</div>
                        `;
                        chatBody.appendChild(welcomeWrapper);
                    } else {
                        messages.forEach(msg => {
                            const wrapper = document.createElement('div');
                            wrapper.className = 'chat-msg ' + (msg.from === 'user' ? 'chat-msg--admin' : 'chat-msg--customer');
                            wrapper.innerHTML = `
                                <div class="chat-bubble">${msg.text}</div>
                                <div class="chat-meta">${msg.time}</div>
                            `;
                            chatBody.appendChild(wrapper);
                        });
                    }
                    chatBody.scrollTop = chatBody.scrollHeight;
                }

                function openChatWindow(id) {
                    const meta = tablesMetadata[id] || { name: 'Meja ' + String(id).padStart(2, '0'), status: 'TERSEDIA', color: '#00e5ff' };

                    // Clear unread flag for this table when opening chat
                    markTableAsRead(id);

                    document.getElementById('chatTableName').textContent = meta.name;
                    document.getElementById('chatStatus').textContent = meta.status;
                    document.getElementById('chatStatus').style.color = meta.color;
                    document.querySelector('.chat-popup-dot').style.color = meta.color;
                    document.getElementById('chatUserName').textContent = "Admin";

                    renderUserMessages(id);
                    chatPopup.dataset.activeTableId = id;

                    chatOverlay.classList.add('active');
                    chatPopup.classList.add('active');
                    setTimeout(() => chatInput.focus(), 150);
                }
                window.openChatWindow = openChatWindow;

                function closeChatPopup() {
                    chatOverlay.classList.remove('active');
                    chatPopup.classList.remove('active');
                    chatPopup.dataset.activeTableId = '';
                }

                // Attach to table card chat buttons dynamically (e.g. if we are on meja page)
                document.addEventListener('click', function(e) {
                    const cardBtn = e.target.closest('.tm-btn-chat');
                    if (cardBtn) {
                        e.stopPropagation();
                        const parentTable = cardBtn.closest('.billiard-table');
                        if (parentTable) {
                            const id = parentTable.dataset.id;
                            openChatWindow(id);
                        }
                    }
                });


                if (chatCloseBtn) chatCloseBtn.addEventListener('click', closeChatPopup);
                if (chatOverlay) chatOverlay.addEventListener('click', closeChatPopup);

                if (chatSendBtn) {
                    chatSendBtn.addEventListener('click', () => {
                        const text = chatInput.value.trim();
                        const tableId = chatPopup.dataset.activeTableId;
                        if (!text || !tableId) return;

                        chatInput.value = '';

                        const now = new Date();
                        const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

                        if (!userChatData[tableId]) {
                            const meta = tablesMetadata[tableId] || { name: 'Meja ' + String(tableId).padStart(2, '0'), status: 'TERSEDIA', color: '#00e5ff' };
                            userChatData[tableId] = {
                                table: meta.name.toUpperCase(),
                                status: meta.status,
                                statusColor: meta.color,
                                user: '{{ auth()->user()->name }}',
                                messages: []
                            };
                        }
                        
                        // Optimistically render locally
                        userChatData[tableId].messages.push({ from: 'user', text: text, time: timeStr });
                        userChatData[tableId].hasUnreadForAdmin = true;
                        localStorage.setItem('billiard_chat_history', JSON.stringify(userChatData));
                        renderUserMessages(tableId);

                        // Save to database via dedicated endpoint
                        fetch('{{ route("chat.send") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                table_id: tableId,
                                message: text
                            })
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.success) {
                                syncChatWithDatabase();
                            }
                        })
                        .catch(err => console.error('Send message error:', err));
                    });

                    chatInput.addEventListener('keypress', function (e) {
                        if (e.key === 'Enter') {
                            chatSendBtn.click();
                        }
                    });
                }

                window.addEventListener('storage', (e) => {
                    if (e.key === 'billiard_chat_history') {
                        userChatData = JSON.parse(e.newValue);
                        updateUserBadges();

                        const activeId = chatPopup.dataset.activeTableId;
                        if (activeId && chatPopup.classList.contains('active')) {
                            if (userChatData[activeId] && userChatData[activeId].hasUnreadForUser) {
                                markTableAsRead(activeId);
                            }
                            renderUserMessages(activeId);
                        }
                    }
                });

                // Initial badge setup & start background sync loop
                updateUserBadges();
                syncChatWithDatabase();
                setInterval(syncChatWithDatabase, 3000);
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>
