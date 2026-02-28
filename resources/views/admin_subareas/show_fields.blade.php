<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $subarea->id }}</p>
</div>

<!-- Area (Arabic) Field -->
<div class="col-sm-6">
    {!! Form::label('area', 'Area (Arabic):') !!}
    <p>{{ $subarea->area }}</p>
</div>

<!-- Area (English) Field -->
<div class="col-sm-6">
    {!! Form::label('area_en', 'Area (English):') !!}
    <p>{{ $subarea->area_en }}</p>
</div>
