<!-- Type Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('type', 'النوع:'); ?> <span class="text-danger">*</span>
    <?php echo Form::select('type', ['0' => 'مستخدم محدد', '1' => 'كل المستخدمين'], null, ['class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('type')); ?></small>
</div>

<!-- User Id Field -->
<div id="user_phonediv" class="form-group col-sm-6">
    <?php echo Form::label('user_id', 'المستخدم:'); ?>

    <?php echo Form::select('user_id', $users, null, ['placeholder' => 'اختر مستخدماً...', 'class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('user_id')); ?></small>
</div>

<!-- Title Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('title', 'العنوان:'); ?> <span class="text-danger">*</span>
    <?php echo Form::text('title', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('title')); ?></small>
</div>

<!-- Title En Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('title_en', 'العنوان (إنجليزي):'); ?>

    <?php echo Form::text('title_en', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('title_en')); ?></small>
</div>

<!-- Message Field -->
<div class="form-group col-sm-12 col-lg-12">
    <?php echo Form::label('message', 'الرسالة:'); ?> <span class="text-danger">*</span>
    <?php echo Form::textarea('message', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('message')); ?></small>
</div>

<!-- Message En Field -->
<div class="form-group col-sm-12 col-lg-12">
    <?php echo Form::label('message_en', 'الرسالة (إنجليزي):'); ?>

    <?php echo Form::textarea('message_en', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('message_en')); ?></small>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('status', 'الحالة:'); ?>

    <?php echo Form::select('status', ['0' => 'غير مقروء', '1' => 'مقروء'], null, ['class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('status')); ?></small>
</div>
<?php /**PATH /var/www/html/resources/views/admin_notifications/fields.blade.php ENDPATH**/ ?>