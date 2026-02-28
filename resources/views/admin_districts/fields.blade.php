<!-- District (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('district', 'District (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('district', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('district') }}</small>
</div>

<!-- District (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('district_en', 'District (English):') !!}
    {!! Form::text('district_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('district_en') }}</small>
</div>

<!-- Governrate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('govern_id', 'Governrate:') !!} <span class="text-danger">*</span>
    {!! Form::select('govern_id', $governrate, null, ['class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('govern_id') }}</small>
</div>

<div class="clearfix"></div>
