<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $floor->id }}</p>
</div>

<!-- Floor (Arabic) Field -->
<div class="col-sm-6">
    {!! Form::label('floor', 'Floor (Arabic):') !!}
    <p>{{ $floor->floor }}</p>
</div>

<!-- Floor (English) Field -->
<div class="col-sm-6">
    {!! Form::label('floor_en', 'Floor (English):') !!}
    <p>{{ $floor->floor_en }}</p>
</div>
