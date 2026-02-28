<!-- Governrate (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('governrate', 'Governrate (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('governrate', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('governrate') }}</small>
</div>

<!-- Governrate (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('governrate_en', 'Governrate (English):') !!}
    {!! Form::text('governrate_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('governrate_en') }}</small>
</div>

<div class="clearfix"></div>
