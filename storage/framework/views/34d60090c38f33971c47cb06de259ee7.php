<!-- Id Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('id', 'ID:'); ?>

    <p><?php echo e($contactForm->id); ?></p>
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('name', 'الاسم:'); ?>

    <p><?php echo e($contactForm->name); ?></p>
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('phone', 'الهاتف:'); ?>

    <p><?php echo e($contactForm->phone); ?></p>
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('email', 'البريد الإلكتروني:'); ?>

    <p><?php echo e($contactForm->email); ?></p>
</div>

<!-- Subject Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('subject', 'الموضوع:'); ?>

    <p><?php echo e($contactForm->subject); ?></p>
</div>

<!-- Body Field -->
<div class="form-group col-sm-12">
    <?php echo Form::label('body', 'الرسالة:'); ?>

    <p><?php echo e($contactForm->body); ?></p>
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('created_at', 'تاريخ الإرسال:'); ?>

    <p><?php echo e($contactForm->created_at); ?></p>
</div>
<?php /**PATH /var/www/html/resources/views/admin_contact_forms/show_fields.blade.php ENDPATH**/ ?>