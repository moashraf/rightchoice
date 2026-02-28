<div class="card-header mb-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Property type and location</h4>
</div>

<!-- Category Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('category', 'Category:'); ?> <span class="text-danger">*</span>
    <?php echo Form::select('category', $aqarcategory, null, ['class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('category')); ?></small>
</div>

<!-- Property Type Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('property_type', 'Property Type:'); ?> <span class="text-danger">*</span>
    <select name="property_type" class="form-control custom-select">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $propertytype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propertytype_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($propertytype_val->id); ?>" <?php if(@$aqar->property_type == $propertytype_val->id): ?> selected <?php endif; ?>><?php echo e($propertytype_val->property_type); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </select>
    <small class="text-danger"><?php echo e($errors->first('property_type')); ?></small>
</div>

<!-- Compound Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('compound', 'Compound:'); ?>

    <select name="compound" class="form-control custom-select">
        <option value="">اختار</option>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $compound; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat_compound): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cat_compound->id); ?>" <?php if(@$aqar->compound == $cat_compound->id): ?> selected <?php endif; ?>><?php echo e($cat_compound->compound); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </select>
</div>

<!-- Governrate Id Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('governrate_id', 'Governrate:'); ?> <span class="text-danger">*</span>
    <?php echo Form::select('governrate_id', $governrate, null, ['class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('governrate_id')); ?></small>
</div>

<!-- Slug (Governrate) Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('slug', 'Slug:'); ?> <span class="text-danger">*</span>
    <?php echo Form::select('slug', $governrate, null, ['class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('slug')); ?></small>
</div>

<!-- District Id Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('district_id', 'District:'); ?> <span class="text-danger">*</span>
    <select name="district_id" class="form-control custom-select">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cat->id); ?>" <?php if(@$aqar->district_id == $cat->id): ?> selected <?php endif; ?>><?php echo e($cat->district); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </select>
    <small class="text-danger"><?php echo e($errors->first('district_id')); ?></small>
</div>

<!-- Area Id Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('area_id', 'Area:'); ?>

    <?php echo Form::select('area_id', $subarea, null, ['placeholder' => 'Please select ...', 'class' => 'form-control custom-select']); ?>

</div>

<div class="card-header mb-3 mt-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Ad details</h4>
</div>

<!-- User Id Field -->
<div id="user_name" class="form-group col-sm-12">
    <?php echo Form::label('user_id', 'User:'); ?> <span class="text-danger">*</span>
    <?php echo Form::select('user_id', $users, null, ['placeholder' => 'Please select ...', 'class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('user_id')); ?></small>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::current()->getName() == 'sitemanagement.aqars.edit'): ?>
    <div id="user_phonediv" class="form-group col-sm-4">
        <?php echo Form::label('user_phone', 'User Phone:'); ?>

        <?php echo Form::input('user_phone', 'user_phone', $getPhoneFirst->MOP ?? '', ['class' => 'form-control user_phone', 'readonly']); ?>

    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<!-- Call Id Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('call_id', 'Times to contact:'); ?> <span class="text-danger">*</span>
    <?php echo Form::select('call_id', $callTimes, null, ['class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('call_id')); ?></small>
</div>

<!-- Title Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('title', 'Title:'); ?> <span class="text-danger">*</span>
    <?php echo Form::text('title', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('title')); ?></small>
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('slug', 'Slug:'); ?> <span class="text-danger">*</span>
    <?php echo Form::text('slug', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('slug')); ?></small>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    <?php echo Form::label('description', 'Description:'); ?> <span class="text-danger">*</span>
    <?php echo Form::textarea('description', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('description')); ?></small>
</div>

<!-- Title_en Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('title_en', 'Title_en:'); ?> <span class="text-danger">*</span>
    <?php echo Form::text('title_en', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('title_en')); ?></small>
</div>

<!-- Slug_en Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('slug_en', 'Slug_en:'); ?> <span class="text-danger">*</span>
    <?php echo Form::text('slug_en', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('slug_en')); ?></small>
</div>

<!-- Description_en Field -->
<div class="form-group col-sm-12 col-lg-12">
    <?php echo Form::label('description_en', 'Description_en:'); ?> <span class="text-danger">*</span>
    <?php echo Form::textarea('description_en', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('description_en')); ?></small>
</div>

<div class="card-header mb-3 mt-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Ad Specifications</h4>
</div>

<!-- Offer Type Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('offer_type', 'Offer Type:'); ?> <span class="text-danger">*</span>
    <?php echo Form::select('offer_type', $offertype, null, ['class' => 'form-control custom-select']); ?>

    <small class="text-danger"><?php echo e($errors->first('offer_type')); ?></small>
</div>

<!-- Total Area Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('total_area', 'Total Area:'); ?>

    <?php echo Form::number('total_area', null, ['class' => 'form-control']); ?>

</div>

<!-- Finishtype Field -->
<div id="finishtype" class="form-group col-sm-4">
    <?php echo Form::label('finishtype', 'Finishtype:'); ?>

    <?php echo Form::select('finishtype', $finishtype, null, ['class' => 'form-control custom-select']); ?>

</div>

<!-- Floor Field -->
<div id="floor" class="form-group col-sm-4">
    <?php echo Form::label('floor', 'Floor:'); ?>

    <?php echo Form::select('floor', $floor, null, ['class' => 'form-control custom-select']); ?>

</div>

<!-- Rooms Field -->
<div id="rooms" class="form-group col-sm-4">
    <?php echo Form::label('rooms', 'Number of rooms:'); ?>

    <?php echo Form::number('rooms', null, ['class' => 'form-control']); ?>

</div>

<!-- Baths Field -->
<div id="baths" class="form-group col-sm-4">
    <?php echo Form::label('baths', 'Number of bathrooms:'); ?>

    <?php echo Form::number('baths', null, ['class' => 'form-control']); ?>

</div>

<!-- License Type Field -->
<div id="license_type" class="form-group col-sm-4">
    <?php echo Form::label('license_type', 'License Type:'); ?>

    <?php echo Form::select('license_type', $licensetype, null, ['class' => 'form-control custom-select']); ?>

</div>

<!-- Finannce Bank Field -->
<div id="finannce_bank" class="form-group col-sm-4">
    <?php echo Form::label('finannce_bank', 'Finannce Bank:'); ?>

    <?php echo Form::select('finannce_bank', ['No', 'Yes'], null, ['class' => 'form-control custom-select']); ?>

</div>

<!-- Licensed Field -->
<div id="licensed" class="form-group col-sm-4">
    <?php echo Form::label('licensed', 'Licensed:'); ?>

    <?php echo Form::select('licensed', ['No', 'Yes'], null, ['class' => 'form-control custom-select']); ?>

</div>

<!-- Trade Field -->
<div id="trade" class="form-group col-sm-4">
    <?php echo Form::label('trade', 'Trade:'); ?>

    <?php echo Form::select('trade', ['No', 'Yes'], null, ['class' => 'form-control custom-select']); ?>

</div>

<!-- Number Of Floors Field -->
<div id="number_of_floors" class="form-group col-sm-6">
    <?php echo Form::label('number_of_floors', 'Number Of Floors:'); ?>

    <?php echo Form::number('number_of_floors', null, ['class' => 'form-control']); ?>

</div>

<!-- Monthly Rent Field -->
<div id="monthly_rent" class="form-group col-sm-6">
    <?php echo Form::label('monthly_rent', 'Monthly Rent:'); ?> <span class="text-danger">*</span>
    <?php echo Form::number('monthly_rent', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('monthly_rent')); ?></small>
</div>

<!-- Total Price Field -->
<div id="total_price" class="form-group col-sm-6">
    <?php echo Form::label('total_price', 'Total Price:'); ?> <span class="text-danger">*</span>
    <?php echo Form::text('total_price', null, ['class' => 'form-control']); ?>

    <small class="text-danger"><?php echo e($errors->first('total_price')); ?></small>
</div>

<div class="row col-md-12">
    <!-- Downpayment Field -->
    <div id="installment_downpayment" class="form-group col-sm-4">
        <?php echo Form::label('downpayment', 'Downpayment:'); ?>

        <?php echo Form::number('downpayment', null, ['class' => 'form-control']); ?>

    </div>

    <!-- Installment Time Field -->
    <div id="installment_time" class="form-group col-sm-4">
        <?php echo Form::label('installment_time', 'Installment Time:'); ?>

        <?php echo Form::number('installment_time', null, ['class' => 'form-control']); ?>

    </div>

    <!-- Reciving Field -->
    <div id="installment_reciving" class="form-group col-sm-4">
        <?php echo Form::label('reciving', 'Receiving:'); ?>

        <?php echo Form::select('reciving', ['Fawry', 'Not Fawry'], null, ['class' => 'form-control custom-select']); ?>

    </div>

    <!-- VIP Field -->
    <div class="form-group col-sm-6">
        <?php echo Form::label('vip', 'Vip:'); ?>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="vip" id="vip-yes" value="1"
                <?php if(@$aqar->vip == 1): ?> checked <?php endif; ?>>
            <label class="form-check-label" for="vip-yes">Yes</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="vip" id="vip-no" value="0"
                <?php if(@$aqar->vip == 0): ?> checked <?php endif; ?>>
            <label class="form-check-label" for="vip-no">No</label>
        </div>
    </div>
</div>

<!-- Rec Time Field -->
<div id="rec_time" class="form-group col-sm-6">
    <?php echo Form::label('rec_time', 'Year Of Receipt:'); ?>

    <?php echo Form::text('rec_time', null, ['class' => 'form-control']); ?>

</div>

<!-- Points Avail Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('points_avail', 'Points Avail:'); ?>

    <?php echo Form::text('points_avail', null, ['class' => 'form-control']); ?>

</div>

<!-- Views Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('views', 'Views:'); ?>

    <?php echo Form::number('views', null, ['class' => 'form-control']); ?>

</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    <?php echo Form::label('status', 'Status:'); ?>

    <select class="form-control" name="status">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = \App\Enums\StatusEnum::values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($case); ?>" <?php if(@$aqar->status == $case): ?> selected <?php endif; ?>><?php echo e($key); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </select>
</div>

<div class="card-header mb-3 mt-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Ad Advantages</h4>
</div>

<div class="col-md-12 mb-3">
    <?php echo Form::label('perpert_id', 'Advantages:'); ?>

    <input id="chkall" type="checkbox" class="ml-3">
    <?php echo Form::label('chkall', 'Select All:'); ?>

    <select class="select2 select2-multiple" style="width: 100%" multiple="multiple" name="feature_id[]"
            data-placeholder="Choose" id="selecttested">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($mzaya)): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $mzaya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $use): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($use->id); ?>"
                    <?php if(!empty($mzayaAqar)): ?>
                        <?php $__currentLoopData = $mzayaAqar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($gt->mzaya_id == $use->id): ?> selected <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                ><?php echo e($use->mzaya_type); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </select>
</div>

<div class="card-header mb-3 mt-2 col-12">
    <h4 class="mb-0" style="color: gray;"> Ad Images</h4>
</div>

<div class="col-md-7">
    <label class="font-bold"><h4>Images<span style="color: red">*</span></h4></label>
</div>
<div class="col-md-3">
    <a class="btn btn-danger waves-effect waves-light addimg">
        <i class="fas fa-plus"></i>
        <i class="fas fa-image"></i>
    </a>
</div>
<div class="clearfix"></div>
<div class="imagesmore col-sm-12"></div>

<div class="row mt-3">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($aqar->Images)): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $aqar->Images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 mt-3">
                <div class="col-md-8 ml-4">
                    <input type="text" <?php if($img->main_img == 1): ?> value="Main Image" <?php else: ?> value="Normal Image" <?php endif; ?>
                        class="form-control" style="text-align: center;" readonly>
                </div>
                <div class="img-thumbnail text-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($img->img_url)): ?>
                        <a href="<?php echo e(url('public/images/' . $img->img_url)); ?>" data-toggle="lightbox">
                            <img src="<?php echo e(url('public/images/' . $img->img_url)); ?>" width="100%" height="140"/>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <a onclick="return confirm('Are You Sure You Want To Delete This Record ?')"
                       href="<?php echo e(route('sitemanagement.aqars.removeImage', $img->id)); ?>"
                       class="btn waves-effect waves-light btn-danger"
                       style="padding: 0.375rem 2.36rem; font-size: .875rem; border-radius: 0;">
                        <i class="far fa-trash-alt"> delete</i>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /var/www/html/resources/views/admin_aqars/fields.blade.php ENDPATH**/ ?>