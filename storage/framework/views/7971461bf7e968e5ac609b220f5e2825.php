
<aside class="adm-sidebar">
    <div class="adm-sidebar-top">
        
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

        
        <nav class="adm-nav">
            <a href="<?php echo e(route('dashboard')); ?>" class="adm-nav-link <?php echo e(Request::is('dashboard') ? 'active' : ''); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1" />
                    <rect width="7" height="5" x="14" y="3" rx="1" />
                    <rect width="7" height="9" x="14" y="12" rx="1" />
                    <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="<?php echo e(route('user.meja')); ?>"
                class="adm-nav-link <?php echo e(Request::is('dashboard/meja*') ? 'active' : ''); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v3H3V8Z" />
                    <path d="M6 11v9" />
                    <path d="M18 11v9" />
                    <path d="M6 15h12" />
                </svg>
                <span>Meja</span>
            </a>
            <a href="<?php echo e(route('user.fnb')); ?>" class="adm-nav-link <?php echo e(Request::is('dashboard/fnb*') ? 'active' : ''); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2" />
                    <path d="M7 2v20" />
                    <path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7" />
                </svg>
                <span>Pesan Makanan dan Minuman</span>
            </a>
            <a href="<?php echo e(route('user.history')); ?>" class="adm-nav-link <?php echo e(Request::is('dashboard/history*') ? 'active' : ''); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                <span>History Booking</span>
            </a>
        </nav>
    </div>

    
    <div class="adm-sidebar-bottom">
        <form action="<?php echo e(route('logout')); ?>" method="POST" id="logout-sidebar-form">
            <?php echo csrf_field(); ?>
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
<script src="<?php echo e(asset('js/js_component/mobile_menu.js')); ?>"></script><?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/component/c_dashboard/sidebar/sidebar_user.blade.php ENDPATH**/ ?>