
<?php $__env->startSection('title', 'Property Types'); ?>
<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>أنواع العقارات</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" href="<?php echo e(route('sitemanagement.propertyTypes.create')); ?>">
                        إضافة جديد
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                <?php echo $__env->make('admin_property_types.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin_property_types/index.blade.php ENDPATH**/ ?>