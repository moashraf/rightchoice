<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $compound->id }}</p>
</div>

<!-- Compound (Arabic) Field -->
<div class="col-sm-6">
    {!! Form::label('compound', 'Compound (Arabic):') !!}
    <p>{{ $compound->compound }}</p>
</div>

<!-- Compound (English) Field -->
<div class="col-sm-6">
    {!! Form::label('compound_en', 'Compound (English):') !!}
    <p>{{ $compound->compound_en }}</p>
</div>
