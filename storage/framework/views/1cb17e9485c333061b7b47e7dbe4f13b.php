
<?php $__env->startSection('title', 'إنشاء عقار'); ?>
<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>إنشاء عقار</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="card">
            <?php echo Form::open(['route' => 'sitemanagement.aqars.store']); ?>


            <div class="card-body">
                <div class="row">
                    <?php echo $__env->make('admin_aqars.fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>

            <div class="card-footer">
                <?php echo Form::submit('Save', ['class' => 'btn btn-primary']); ?>

                <a href="<?php echo e(route('sitemanagement.aqars.index')); ?>" class="btn btn-default">الغاء</a>
            </div>

            <?php echo Form::close(); ?>

        </div>
    </div>

<?php $__env->startSection('footerScript'); ?>
<script>
    $(document).ready(function() {
        var cheackus = $("select[name='user_id']").val();
        $("select[name='user_id']").change(function() {
            if($(this).val() >= 1) {
                $("#user_phonediv").show(2000);
                $("#user_name").removeClass("form-group col-sm-12").addClass("form-group col-sm-6");
            } else {
                $("#user_phonediv").hide(2000);
                $("#user_name").removeClass("form-group col-sm-6").addClass("form-group col-sm-12");
            }
        });
        $("#user_phonediv").hide(2000);
        $("#user_name").removeClass("form-group col-sm-6").addClass("form-group col-sm-12");
    });
</script>
<script type="text/javascript">
    $("select[name='category']").change(function () {
        var category = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "<?php echo e(url('sitemanagement/ajax-getpropertyByCat')); ?>",
            method: 'POST',
            data: { category: category, _token: token },
            success: function (data) {
                var myCities = $('select[name="property_type"]');
                myCities.find('option').remove();
                if (data.status != 401) {
                    $.each(data.data, function (key, val) {
                        myCities.append('<option value="' + val.id + '">' + val.property_type + '</option>');
                    });
                } else {
                    myCities.append('<option value="">-- No Data Fetch --</option>');
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $("select[name='governrate_id']").change(function () {
        var governrate_id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "<?php echo e(url('sitemanagement/ajax-getdistrictByGovernrate')); ?>",
            method: 'POST',
            data: { governrate_id: governrate_id, _token: token },
            success: function (data) {
                var myCities = $('select[name="district_id"]');
                myCities.find('option').remove();
                if (data.status != 401) {
                    $.each(data.data, function (key, val) {
                        myCities.append('<option value="' + val.id + '">' + val.district + '</option>');
                    });
                } else {
                    myCities.append('<option value="">-- No Data Fetch --</option>');
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $("select[name='user_id']").change(function () {
        var user_id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "<?php echo e(url('sitemanagement/ajax-getPhoneUser')); ?>",
            method: 'POST',
            data: { user_id: user_id, _token: token },
            success: function (data) {
                var myCities = $('input[name="user_phone"]');
                $('.user_phone').val('');
                if (data.status != 401) {
                    $.each(data.data, function (key, val) {
                        $('.user_phone').val(val.MOP);
                    });
                } else {
                    myCities.append('value="No Data Fetch"');
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin_aqars/create.blade.php ENDPATH**/ ?>