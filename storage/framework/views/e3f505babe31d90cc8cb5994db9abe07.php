<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Menu — Jay's Billiard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo e(asset('css/css_layout/app_admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/css_page/css_interaksi page/buat_menu.css')); ?>">
</head>
<body>
    <div class="adm-layout">
        <?php echo $__env->make('component.c_dashboard.sidebar.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <main class="adm-main">
            
            <?php echo $__env->make('component.c_dashboard.topbar.topbar', [
                'topbar_title' => 'Makanan & Minuman',
                'topbar_sub' => "Kelola kebutuhan amunisi pemain billiar"
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="adm-content adm-interaksi-content">
                
                
                <div class="adm-breadcrumb-row">
                    <a href="<?php echo e(route('admin.menu')); ?>" class="adm-back-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </a>
                    <span class="adm-breadcrumb-text">
                        Makanan dan Minuman <span class="breadcrumb-sep">•</span> <strong>Edit Menu</strong>
                    </span>
                </div>

                <form action="<?php echo e(route('admin.menu.update', $menu->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <?php if($errors->any()): ?>
                        <div class="adm-form-alert">
                            <strong>Menu belum bisa disimpan.</strong>
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    
                    <div class="adm-interaksi-grid">
                        
                        
                        <div class="adm-column-left">
                            
                            
                            <div class="adm-inter-panel panel-preview">
                                <h2 class="panel-title">Preview Card - Edit Menu</h2>
                                <div class="preview-card-wrap">
                                    <div class="adm-menu-card-preview">
                                        <div class="preview-img-box">
                                            <img src="<?php echo e($menu->image ? asset('storage/' . $menu->image) : 'https://images.unsplash.com/photo-1544145945-f904253db0ad?auto=format&fit=crop&q=80&w=400'); ?>" id="previewImg" alt="<?php echo e($menu->name); ?>">
                                            <span class="preview-price" id="previewPriceText">Rp <?php echo e(number_format($menu->price, 0, ',', '.')); ?></span>
                                        </div>
                                        <div class="preview-body">
                                            <div class="preview-header">
                                                <h3 class="preview-name" id="previewNameText"><?php echo e($menu->name); ?></h3>
                                                <div class="preview-status">
                                                    <span class="status-dot"></span>
                                                    <?php echo e(strtoupper($menu->status === 'available' ? 'Tersedia' : 'Kosong')); ?>

                                                </div>
                                            </div>
                                            <div class="preview-detail">
                                                <span class="detail-category" id="previewCatText"><?php echo e(strtoupper($menu->category)); ?></span>
                                                <span class="detail-name">Lorem</span>
                                            </div>
                                            <p class="preview-desc" id="previewDescText"><?php echo e($menu->description ?: '.Lorem ipsum dolor sit amet'); ?></p>
                                        </div>
                                        <div class="preview-footer">
                                            <button type="button" class="btn-preview-edit">EDIT MENU</button>
                                            <div class="btn-preview-delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="adm-inter-panel panel-upload">
                                <h2 class="panel-title">Ganti Gambar</h2>
                                <label for="menuImage" class="adm-upload-zone">
                                    <input type="file" name="image" id="menuImage" hidden onchange="previewFile()">
                                    <div class="upload-icon-wrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/><path d="M12 11V17"/><path d="M9 14H15"/></svg>
                                    </div>
                                    <span class="upload-text">Unggah Gambar Baru</span>
                                    <span class="upload-hint">PNG, JPG hingga 10MB</span>
                                </label>
                            </div>

                        </div>

                        
                        <div class="adm-column-right">

                            
                            <div class="adm-inter-panel panel-status">
                                <h2 class="panel-title">Status Menu</h2>
                                <div class="adm-status-grid">
                                    <div class="adm-status-box available <?php echo e($menu->status === 'available' ? 'active' : ''); ?>" onclick="setStatus('available', this)">
                                        <div class="status-indicator"></div>
                                        <div class="status-text-wrap">
                                            <span class="status-dot-glow"></span>
                                            <span class="status-label-text">Tersedia</span>
                                        </div>
                                    </div>
                                    <div class="adm-status-box unavailable <?php echo e($menu->status === 'unavailable' ? 'active' : ''); ?>" onclick="setStatus('unavailable', this)">
                                        <div class="status-indicator"></div>
                                        <div class="status-text-wrap">
                                            <span class="status-dot-glow"></span>
                                            <span class="status-label-text">Kosong</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="status" id="menuStatus" value="<?php echo e($menu->status); ?>">
                            </div>

                            <div class="adm-inter-panel panel-form">
                                <h2 class="panel-title">Edit Data Makanan</h2>
                                
                                <div class="adm-form-group">
                                    <label class="adm-label">Nama Menu</label>
                                    <input type="text" name="name" id="inputName" class="adm-input" value="<?php echo e($menu->name); ?>" required oninput="updatePreview()">
                                </div>

                                <div class="adm-form-row">
                                    <div class="adm-form-group">
                                        <label class="adm-label">Harga</label>
                                        <div class="adm-input-wrap">
                                            <span class="adm-input-prefix">Rp</span>
                                            <input type="number" name="price" id="inputPrice" class="adm-input adm-input--prefixed" value="<?php echo e($menu->price); ?>" required oninput="updatePreview()">
                                            <div class="adm-input-arrows">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 10 17 15"></polyline></svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 9 12 14 17 9"></polyline></svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adm-form-group">
                                        <label class="adm-label">Kategori</label>
                                        <?php echo $__env->make('component.c_dashboard.dropdown.option_kategori', [
                                            'id' => 'categoryDropdown',
                                            'name' => 'category',
                                            'placeholder' => $menu->category
                                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                </div>

                                <div class="adm-form-group">
                                    <label class="adm-label">Deskripsi</label>
                                    <textarea name="description" id="inputDesc" class="adm-textarea" oninput="updatePreview()"><?php echo e($menu->description); ?></textarea>
                                </div>
                            </div>

                            <div class="adm-form-actions">
                                <a href="<?php echo e(route('admin.menu')); ?>" class="btn-form-cancel">Cancel</a>
                                <button type="submit" class="btn-form-submit">Update Menu</button>
                            </div>
                        </div>

                    </div>
                </form>

                <script>
                    function setStatus(status, el) {
                        // Update Hidden Input
                        document.getElementById('menuStatus').value = status;
                        
                        // Update UI classes
                        document.querySelectorAll('.adm-status-box').forEach(box => {
                            box.classList.remove('active');
                        });
                        el.classList.add('active');

                        // Update Preview Status Text
                        const previewStatusText = document.querySelector('.preview-status');
                        if (status === 'available') {
                            previewStatusText.innerHTML = '<span class="status-dot"></span> TERSEDIA';
                            previewStatusText.style.color = 'var(--cyan)';
                        } else {
                            previewStatusText.innerHTML = '<span class="status-dot" style="background:#5a6470;box-shadow:none;"></span> KOSONG';
                            previewStatusText.style.color = 'rgba(255,255,255,0.2)';
                        }
                    }

                    function updatePreview() {
                        const name = document.getElementById('inputName').value;
                        const price = document.getElementById('inputPrice').value;
                        const desc = document.getElementById('inputDesc').value;
                        
                        document.getElementById('previewNameText').innerText = name || 'Lorem';
                        document.getElementById('previewPriceText').innerText = 'Rp ' + (price ? new Intl.NumberFormat('id-ID').format(price) : 'Lorem');
                        document.getElementById('previewDescText').innerText = (desc || '.Lorem ipsum dolor sit amet');
                    }

                    // Add listener for Category Dropdown items to update preview
                    document.addEventListener('DOMContentLoaded', function() {
                        const catItems = document.querySelectorAll('.adm-kategori-item');
                        catItems.forEach(item => {
                            item.addEventListener('click', function() {
                                document.getElementById('previewCatText').innerText = this.textContent;
                            });
                        });
                    });

                    function previewFile() {
                        const preview = document.getElementById('previewImg');
                        const file = document.getElementById('menuImage').files[0];
                        const reader = new FileReader();

                        reader.onloadend = function () {
                            preview.src = reader.result;
                        }

                        if (file) {
                            reader.readAsDataURL(file);
                        }
                    }

                    // Form Submission Feedback
                    document.querySelector('form').addEventListener('submit', function() {
                        const btn = this.querySelector('.btn-form-submit');
                        btn.innerHTML = '<svg class="animate-spin" style="width:18px;height:18px;margin-right:8px" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" stroke-dasharray="32" /></svg> Memproses...';
                        btn.style.opacity = '0.7';
                        btn.style.pointerEvents = 'none';
                    });
                </script>
                
                <style>
                    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
                    .animate-spin { animation: spin 1s linear infinite; vertical-align: middle; }
                </style>




            </div>
        </main>
    </div>
    <script src="<?php echo e(asset('js/js_component/option_kategori.js')); ?>"></script>
    
    
    <?php echo $__env->make('component.c_dashboard.modal.logout_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="<?php echo e(asset('js/js_component/logout.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/dashboard_admin/menu/edit_menu.blade.php ENDPATH**/ ?>