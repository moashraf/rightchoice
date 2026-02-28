<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $callTime->id }}</p>
</div>

<!-- Call Time (Arabic) Field -->
<div class="col-sm-6">
    {!! Form::label('call_time', 'Call Time (Arabic):') !!}
    <p>{{ $callTime->call_time }}</p>
</div>

<!-- Call Time (English) Field -->
<div class="col-sm-6">
    {!! Form::label('call_time_en', 'Call Time (English):') !!}
    <p>{{ $callTime->call_time_en }}</p>
</div>
