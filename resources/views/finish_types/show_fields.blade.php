<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $finishType->id }}</p>
</div>

<!-- Finish Type Field -->
<div class="col-sm-12">
    {!! Form::label('finish_type', 'Finish Type:') !!}
    <p>{{ $finishType->finish_type }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $finishType->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $finishType->updated_at }}</p>
</div>

