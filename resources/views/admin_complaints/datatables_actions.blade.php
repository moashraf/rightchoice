{!! Form::open(['route' => ['sitemanagement.complaints.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('sitemanagement.complaints.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-eye text-info font-18"></i>
    </a>
    <a href="{{ route('sitemanagement.complaints.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-edit text-info font-18"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash text-danger font-18"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-default btn-xs',
        'onclick' => "return confirm('هل أنت متأكد؟')"
    ]) !!}
</div>
{!! Form::close() !!}
