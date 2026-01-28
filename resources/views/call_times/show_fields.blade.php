<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $callTime->id }}</p>
</div>

<!-- Call Time Field -->
<div class="col-sm-12">
    {!! Form::label('call_time', 'Call Time:') !!}
    <p>{{ $callTime->call_time }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $callTime->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $callTime->updated_at }}</p>
</div>

