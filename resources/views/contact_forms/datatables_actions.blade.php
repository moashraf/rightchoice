{!! Form::open(['route' => ['contactForms.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('contactForms.show', $id) }}" class='btn btn-default btn-xs'>
        <!-- <i class="glyphicon glyphicon-eye-open"></i> -->
        <i class="fas fa-eye text-info font-18"></i>
    </a>
    <a href="{{ route('contactForms.edit', $id) }}" class='btn btn-default btn-xs'>
        <!-- <i class="glyphicon glyphicon-edit"></i> -->
        <i class="fas fa-edit text-info font-18"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash text-danger font-18"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-default btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
