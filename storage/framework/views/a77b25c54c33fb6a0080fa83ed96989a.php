<?php $__env->startSection('third_party_stylesheets'); ?>
    <?php echo $__env->make('layouts.datatables_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']); ?>


<?php $__env->startSection('third_party_scripts'); ?>
    <?php echo $__env->make('layouts.datatables_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $dataTable->scripts(); ?>

<?php $__env->stopSection(); ?>
<?php /**PATH /var/www/html/resources/views/admin_blogs/table.blade.php ENDPATH**/ ?>