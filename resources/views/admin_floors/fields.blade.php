<!-- Floor (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('floor', 'Floor (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('floor', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('floor') }}</small>
</div>

<!-- Floor (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('floor_en', 'Floor (English):') !!}
    {!! Form::text('floor_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('floor_en') }}</small>
</div>

<div class="clearfix"></div>
