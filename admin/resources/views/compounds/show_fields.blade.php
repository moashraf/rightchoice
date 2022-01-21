<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $compound->id }}</p>
</div>

<!-- Compound Field -->
<div class="col-sm-12">
    {!! Form::label('compound', 'Compound:') !!}
    <p>{{ $compound->compound }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $compound->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $compound->updated_at }}</p>
</div>

