<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow, noarchive">
    <title><?php echo $__env->yieldContent('title', "Dashboard — Jay's Billiard"); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo e(asset('css/css_layout/app_admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/css_page/dashboard.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        /**
         * Global Avatar Loader
         */
        function loadGlobalAvatar() {
            const isAdmin = <?php echo e(auth()->check() && auth()->user()->role === 'admin' ? 'true' : 'false'); ?>;
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
    <script src="<?php echo e(asset('js/js_component/logout.js')); ?>"></script>
</head>
<body>
    <div class="adm-layout">
        
        <?php if(Request::is('admin*') || Request::is('admin-dashboard*')): ?>
            <?php echo $__env->make('component.c_dashboard.sidebar.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('component.c_dashboard.sidebar.sidebar_user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        
        <main class="adm-main">
            
            <?php if(!Route::is('admin.profile') && !Route::is('user.profile')): ?>
                <?php echo $__env->make('component.c_dashboard.topbar.topbar', [
                    'topbar_title' => $topbar_title ?? 'Dashboard',
                    'topbar_sub' => $topbar_sub ?? "Kelola kebutuhan operasional jay's billiard"
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>

            
            <div class="adm-content">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    
    <?php echo $__env->make('component.c_dashboard.modal.logout_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>