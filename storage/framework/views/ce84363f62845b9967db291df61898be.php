<!-- Filter Form -->
<form action="<?php echo e(route('sitemanagement.aqars.index')); ?>" class="row align-items-end mb-3">
    <div class="col-md-2">
        <label>الحالة</label>
        <select class="form-control" name="filter_status">
            <option value="">اختر</option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = \App\Enums\StatusEnum::values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($case); ?>" <?php echo e(request('filter_status') !== null ? (request('filter_status') == $case ? 'selected' : '') : ''); ?>><?php echo e($key); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </select>
    </div>
    <div class="col-md-2">
        <label>تمييز</label>
        <select class="form-control" name="filter_vip">
            <option value="">اختر</option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = \App\Enums\VIPEnum::values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($case); ?>" <?php echo e(request('filter_vip') !== null ? (request('filter_vip') == $case ? 'selected' : '') : ''); ?>><?php echo e($key); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label>ترتيب حسب</label>
        <select class="form-control" name="sortBy">
            <option value="">اختر</option>
            <option value="0" <?php echo e(request('sortBy') !== null ? (request('sortBy') == 0 ? 'selected' : '') : ''); ?>>من الاحدث للاقدم</option>
            <option value="1" <?php echo e(request('sortBy') !== null ? (request('sortBy') == 1 ? 'selected' : '') : ''); ?>>من الاقدم للاحدث</option>
        </select>
    </div>
    <div class="col-md-3">
        <label>بحث</label>
        <input type="search" name="key_word" class="form-control" placeholder="بحث بالاسم أو المالك" value="<?php echo e(request('key_word')); ?>">
    </div>
    <div class="col-md-2">
        <button class="btn btn-success">
            <i class="fa fa-filter"></i> فلتر
        </button>
    </div>
</form>

<!-- Table -->
<div class="table-responsive">
    <table class="table" id="datatable">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>الاسم</th>
                <th>محافظه</th>
                <th>نوع الوحده</th>
                <th>التمييز</th>
                <th>الحاله</th>
                <th>اسم المالك</th>
                <th>المشاهدات</th>
                <th>تاريخ الاضافه</th>
                <th>التنفيذ</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $allAqars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allAqars_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($allAqars_val->id); ?></td>
                    <td><?php echo e(\Illuminate\Support\Str::limit($allAqars_val->title, 30, '')); ?></td>
                    <td><?php echo e($allAqars_val->governrateq->governrate ?? ''); ?></td>
                    <td><?php echo e($allAqars_val->propertyType->property_type ?? ''); ?></td>
                    <td><?php echo e($allAqars_val->getVIP()); ?></td>
                    <td><?php echo e($allAqars_val->getStatus()); ?></td>
                    <td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($allAqars_val->user): ?>
                            <a href="<?php echo e(route('sitemanagement.aqars.show', $allAqars_val->id)); ?>">
                                <?php echo e($allAqars_val->user->name); ?>

                            </a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td><?php echo e($allAqars_val->views); ?></td>
                    <td><?php echo e($allAqars_val->created_at ? date_format($allAqars_val->created_at, "Y/m/d") : ''); ?></td>
                    <td>
                        <?php echo Form::open(['route' => ['sitemanagement.aqars.destroy', $allAqars_val->id], 'method' => 'delete']); ?>

                        <div class="btn-group gap-2">
                            <a href="<?php echo e(route('sitemanagement.aqars.show', [$allAqars_val->id])); ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('sitemanagement.aqars.edit', [$allAqars_val->id])); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php echo Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]); ?>

                        </div>
                        <?php echo Form::close(); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
</div>

<div class="card-footer clearfix">
    <div class="float-right">
        <?php echo e($allAqars->appends(request()->query())->links()); ?>

    </div>
</div>
<?php /**PATH /var/www/html/resources/views/admin_aqars/table.blade.php ENDPATH**/ ?>