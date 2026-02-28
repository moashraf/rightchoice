<div class="row col-12">
    <ul class="list-group col-md-6">
        <li class="list-group-item" style="background-color:#343a40; color:#fff; font-weight:bold;">Aqar Details</li>
        <li class="list-group-item"><?php echo Form::label('id', 'Id:'); ?> <?php echo e($aqar->id); ?></li>
        <li class="list-group-item"><?php echo Form::label('slug', 'Slug:'); ?> <?php echo e($aqar->slug); ?></li>
        <li class="list-group-item"><?php echo Form::label('title', 'Title:'); ?> <?php echo e($aqar->title); ?></li>
        <li class="list-group-item"><?php echo Form::label('description', 'Description:'); ?> <?php echo e($aqar->description); ?></li>
        <li class="list-group-item"><?php echo Form::label('governrate', 'Governrate:'); ?> <?php echo e($aqar->governrateq->governrate ?? ''); ?></li>
        <li class="list-group-item"><?php echo Form::label('property_type', 'Property Type:'); ?> <?php echo e($aqar->propertyType->property_type ?? ''); ?></li>
        <li class="list-group-item"><?php echo Form::label('number_of_floors', 'Number Of Floors:'); ?> <?php echo e($aqar->number_of_floors); ?></li>
        <li class="list-group-item"><?php echo Form::label('total_area', 'Total Area:'); ?> <?php echo e($aqar->total_area); ?></li>
        <li class="list-group-item"><?php echo Form::label('rooms', 'Rooms:'); ?> <?php echo e($aqar->rooms); ?></li>
        <li class="list-group-item"><?php echo Form::label('baths', 'Baths:'); ?> <?php echo e($aqar->baths); ?></li>
        <li class="list-group-item"><?php echo Form::label('floor', 'Floor:'); ?> <?php echo e($aqar->floor); ?></li>
        <li class="list-group-item"><?php echo Form::label('ground_area', 'Ground Area:'); ?> <?php echo e($aqar->ground_area); ?></li>
        <li class="list-group-item"><?php echo Form::label('land_area', 'Land Area:'); ?> <?php echo e($aqar->land_area); ?></li>
        <li class="list-group-item"><?php echo Form::label('downpayment', 'Downpayment:'); ?> <?php echo e($aqar->downpayment); ?></li>
        <li class="list-group-item"><?php echo Form::label('monthly_rent', 'Monthly Rent:'); ?> <?php echo e($aqar->monthly_rent); ?></li>
    </ul>

    <ul class="list-group col-md-6">
        <ul class="list-group">
            <li class="list-group-item" style="background-color:#343a40; color:#fff; font-weight:bold;">Aqar Details</li>
            <li class="list-group-item"><?php echo Form::label('rent_long_time', 'Rent Long Time:'); ?> <?php echo e($aqar->rent_long_time); ?></li>
            <li class="list-group-item"><?php echo Form::label('offer_type', 'Offer Type:'); ?> <?php echo e($aqar->offer_type); ?></li>
            <li class="list-group-item"><?php echo Form::label('mtr_price', 'Mtr Price:'); ?> <?php echo e($aqar->mtr_price); ?></li>
            <li class="list-group-item"><?php echo Form::label('total_price', 'Total Price:'); ?> <?php echo e($aqar->total_price); ?></li>
            <li class="list-group-item"><?php echo Form::label('finishtype', 'Finishtype:'); ?> <?php echo e($aqar->finishtype); ?></li>
            <li class="list-group-item"><?php echo Form::label('area_id', 'Area Id:'); ?> <?php echo e($aqar->area_id); ?></li>
            <li class="list-group-item"><?php echo Form::label('views', 'Views:'); ?> <?php echo e($aqar->views); ?></li>
            <li class="list-group-item"><?php echo Form::label('points_avail', 'Aqar Points:'); ?> <?php echo e($aqar->points_avail); ?></li>
            <li class="list-group-item"><?php echo Form::label('created_at', 'Created At:'); ?> <?php echo e($aqar->created_at); ?></li>
            <li class="list-group-item"><?php echo Form::label('updated_at', 'Updated At:'); ?> <?php echo e($aqar->updated_at); ?></li>
            <li class="list-group-item" style="background-color:#343a40; color:#fff; font-weight:bold;">Owner Details</li>
            <li class="list-group-item"><?php echo Form::label('user_id', 'User Id:'); ?> <?php echo e($aqar->user_id); ?></li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item"><?php echo Form::label('user_name', 'User Name:'); ?> <?php echo e($aqar->user->name ?? ''); ?></li>
            <li class="list-group-item"><?php echo Form::label('email', 'Email:'); ?> <?php echo e($aqar->user->email ?? ''); ?></li>
            <li class="list-group-item"><?php echo Form::label('mobile', 'Mobile:'); ?> <?php echo e($aqar->user->MOP ?? ''); ?></li>
        </ul>
    </ul>

    <div class="col-md-12 mt-3">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Viewer Name</th>
                    <th scope="col">Points</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $aqar_viewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aqar_viewer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($aqar_viewer->id); ?></td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aqar_viewer->user): ?>
                                <?php echo e($aqar_viewer->user->name); ?>

                            <?php else: ?>
                                N/A
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td><?php echo e($aqar_viewer->points); ?></td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aqar_viewer->refund == 1): ?>
                                <span data-toggle="modal" data-target="#change_aqar_status_modal">
                                    <button type="button"
                                            data-placement="top"
                                            data-toggle="tooltip"
                                            title="ارجاع النقاط"
                                            data-url="<?php echo e(route('sitemanagement.aqars.refundPoints', $aqar_viewer->id)); ?>"
                                            id="change_aqar_status_btn"
                                            class="btn btn-raised btn-icon btn-danger mr-1">
                                        ارجاع النقاط
                                    </button>
                                </span>
                            <?php else: ?>
                                <button type="button" class="btn btn-raised btn-icon btn-secondary mr-1">
                                    تم ارجاع النقاط
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td></td>
                        <td colspan="2" class="text-center">لا يوجد بيانات</td>
                        <td></td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
        <?php echo e($aqar_viewers->links()); ?>

    </div>
</div>

<!-- Refund Points Modal -->
<div class="modal fade" id="change_aqar_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="" id="change_aqar_status_form">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ارجاع النقاط</h5>
                </div>
                <div class="modal-body">
                    <p>هل انت متاكد من ارجاع النقاط</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-danger">ارجاع</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/admin_aqars/show_fields.blade.php ENDPATH**/ ?>