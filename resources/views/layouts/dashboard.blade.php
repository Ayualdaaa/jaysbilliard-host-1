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
    @stack('scripts')
</body>
</html>
