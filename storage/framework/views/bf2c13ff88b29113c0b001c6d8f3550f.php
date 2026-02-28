
<?php $__env->startSection('title', 'Show Contact Form'); ?>
<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تفاصيل الرسالة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <?php echo $__env->make('admin_contact_forms.show_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo e(route('sitemanagement.contactForms.index')); ?>" class="btn btn-default">رجوع</a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin_contact_forms/show.blade.php ENDPATH**/ ?>