<!-- User Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('user_id', 'المستخدم:'); ?> <span class="text-danger">*</span>
    <?php echo Form::select('user_id', $users, null, ['placeholder' => 'اختر مستخدماً...', 'class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('user_id')); ?></small>
</div>

<!-- Aqar Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('aqars_id', 'العقار:'); ?> <span class="text-danger">*</span>
    <?php echo Form::select('aqars_id', $aqars, null, ['placeholder' => 'اختر العقار...', 'class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('aqars_id')); ?></small>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('status', 'الحالة:'); ?>

    <?php echo Form::select('status', [
        \App\Models\Complaints::COMPLAINT_PENDING    => 'متوقف',
        \App\Models\Complaints::COMPLAINT_INPROGRESS => 'جاري العمل عليه',
        \App\Models\Complaints::COMPLAINT_SOLVED     => 'تم الحل',
    ], null, ['placeholder' => 'اختر الحالة...', 'class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('status')); ?></small>
</div>

<!-- Message Field -->
<div class="form-group col-sm-12">
    <?php echo Form::label('message', 'الرسالة:'); ?> <span class="text-danger">*</span>
    <?php echo Form::textarea('message', null, ['class' => 'form-control', 'rows' => 4]); ?>

    <small class="text-danger"><?php echo e($errors->first('message')); ?></small>
</div>

<div class="clearfix"></div>
<?php /**PATH /var/www/html/resources/views/admin_complaints/fields.blade.php ENDPATH**/ ?>