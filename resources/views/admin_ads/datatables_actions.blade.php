@php
    $authUser  = auth()->guard('admin')->user() ?? auth()->user();
    $canEdit   = $authUser && $authUser->hasPermission('ads.update');
    $canDelete = $authUser && $authUser->hasPermission('ads.delete');
@endphp

<div class='btn-group'>
    <a href="{{ route('sitemanagement.ads.show', $id) }}" class='btn btn-default btn-xs' title="عرض">
        <i class="fas fa-eye text-info font-18"></i>
    </a>

    @if($canEdit)
        <a href="{{ route('sitemanagement.ads.edit', $id) }}" class='btn btn-default btn-xs' title="تعديل">
            <i class="fas fa-edit text-warning font-18"></i>
        </a>
    @endif

    @if($canDelete)
        {!! Form::open(['route' => ['sitemanagement.ads.destroy', $id], 'method' => 'delete', 'style' => 'display:inline']) !!}
            {!! Form::button('<i class="fa fa-trash text-danger font-18"></i>', [
                'type'    => 'submit',
                'class'   => 'btn btn-default btn-xs',
                'title'   => 'حذف',
                'onclick' => "return confirm('هل أنت متأكد من الحذف؟')"
            ]) !!}
        {!! Form::close() !!}
    @endif
</div>
