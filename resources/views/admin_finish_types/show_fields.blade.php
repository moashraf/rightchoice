<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $finishType->id }}</p>
</div>

<!-- Finish Type (Arabic) Field -->
<div class="col-sm-6">
    {!! Form::label('finish_type', 'Finish Type (Arabic):') !!}
    <p>{{ $finishType->finish_type }}</p>
</div>

<!-- Finish Type (English) Field -->
<div class="col-sm-6">
    {!! Form::label('finish_type_en', 'Finish Type (English):') !!}
    <p>{{ $finishType->finish_type_en }}</p>
</div>
