<!-- Area (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area', 'Area (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('area', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('area') }}</small>
</div>

<!-- Area (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area_en', 'Area (English):') !!}
    {!! Form::text('area_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('area_en') }}</small>
</div>

<div class="clearfix"></div>
