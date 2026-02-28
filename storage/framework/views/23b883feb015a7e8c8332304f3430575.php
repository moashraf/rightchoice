
<?php $__env->startSection('title', 'تفاصيل عقار'); ?>
<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تفاصيل عقار</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right" href="<?php echo e(route('sitemanagement.aqars.index')); ?>">
                        رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <?php echo $__env->make('admin_aqars.show_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('page_scripts'); ?>
    <script>
        $(document).on('click', "#change_aqar_status_btn", function () {
            $("#change_aqar_status_form").attr('action', $(this).data('url'));
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin_aqars/show.blade.php ENDPATH**/ ?>