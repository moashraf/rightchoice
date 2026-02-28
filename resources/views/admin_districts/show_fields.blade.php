<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $district->id }}</p>
</div>

<!-- District (Arabic) Field -->
<div class="col-sm-6">
    {!! Form::label('district', 'District (Arabic):') !!}
    <p>{{ $district->district }}</p>
</div>

<!-- District (English) Field -->
<div class="col-sm-6">
    {!! Form::label('district_en', 'District (English):') !!}
    <p>{{ $district->district_en }}</p>
</div>

<!-- Governrate Field -->
<div class="col-sm-6">
    {!! Form::label('govern_id', 'Governrate:') !!}
    <p>{{ $district->govern_id }}</p>
</div>
