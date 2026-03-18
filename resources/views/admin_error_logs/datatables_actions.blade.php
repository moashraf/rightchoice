<div class='btn-group'>
    <a href="{{ route('sitemanagement.errorLogs.show', $id) }}" class='btn btn-default btn-xs' title="عرض التفاصيل">
        <i class="fas fa-eye text-info font-18"></i>
    </a>

    {!! Form::open(['route' => ['sitemanagement.errorLogs.destroy', $id], 'method' => 'delete', 'style' => 'display:inline']) !!}
        {!! Form::button('<i class="fa fa-trash text-danger font-18"></i>', [
            'type'    => 'submit',
            'class'   => 'btn btn-default btn-xs',
            'title'   => 'حذف',
            'onclick' => "return confirm('هل أنت متأكد من الحذف؟')"
        ]) !!}
    {!! Form::close() !!}
</div>
