
<?php
    $selectedValue = $value ?? $placeholder ?? 'Hidangan Utama';
    $categories = ['Hidangan Utama', 'Camilan', 'Minuman', 'Kopi'];
?>

<div class="adm-kategori-dropdown-wrap" id="<?php echo e($id ?? 'categoryDropdown'); ?>">
    
    <div class="adm-kategori-select-box" id="dropdownDisplay">
        <span class="selected-text"><?php echo e($selectedValue); ?></span>
        <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"/>
        </svg>
    </div>

    
    <input type="hidden" name="<?php echo e($name ?? 'category'); ?>" id="dropdownInput" value="<?php echo e($selectedValue); ?>">

    
    <div class="adm-kategori-dropdown-list" id="dropdownList">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="adm-kategori-item <?php echo e($selectedValue === $category ? 'active' : ''); ?>" data-value="<?php echo e($category); ?>"><?php echo e($category); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH C:\laragon\www\jaysbilliard-main\resources\views/component/c_dashboard/dropdown/option_kategori.blade.php ENDPATH**/ ?>