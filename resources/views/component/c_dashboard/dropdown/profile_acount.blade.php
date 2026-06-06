<div class="adm-profile-dropdown" id="profileDropdown">
    <div class="adm-profile-header">
        <div class="adm-user-avatar adm-user-avatar--large">{{ strtoupper(substr(auth()->user()->name ?? 'User', 0, 1)) }}</div>
        <div class="adm-profile-user-info">
            <span class="adm-profile-name">{{ auth()->user()->name ?? 'Ayucantik' }}</span>
            <span
                class="adm-profile-role">{{ (Request::is('admin*') || Request::is('admin-dashboard*')) ? 'Admin' : 'User' }}</span>
        </div>
    </div>
    <div class="adm-profile-divider"></div>
    <a href="{{ auth()->user()->role === 'admin' ? route('admin.profile') : route('user.profile') }}" class="adm-profile-item">
        <span class="adm-profile-item-text">Profile Settings</span>

        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
    </a>
    <div class="adm-profile-divider"></div>
    <form
        action="{{ (Request::is('admin*') || Request::is('admin-dashboard*')) ? route('admin.logout') : route('logout') }}"
        method="POST">
        @csrf
        <button type="button" class="adm-profile-item adm-profile-item--logout adm-logout-trigger"
            onclick="window.confirmLogout(event, this.form)"
            style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 12px 16px;">
            <div class="adm-profile-item-main">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span class="logout-text">Logout</span>
            </div>
        </button>
    </form>
</div>