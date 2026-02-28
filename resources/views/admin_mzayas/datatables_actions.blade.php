{!! Form::open(['route' => ['sitemanagement.mzayas.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('sitemanagement.mzayas.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-eye text-info font-18"></i>
    </a>
    <a href="{{ route('sitemanagement.mzayas.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-edit text-info font-18"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash text-danger font-18"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-default btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
